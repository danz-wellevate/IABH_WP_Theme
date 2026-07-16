const fs = require('fs');
const path = require('path');
const chokidar = require('chokidar');

const baseDir = path.resolve(__dirname, '../');
const blocksDir = path.join(baseDir, 'inc/acf-blocks');
const scssDir = path.join(baseDir, 'assets/scss/components/blocks');
const allScssPath = path.join(scssDir, '_all.scss');

function generateBlockFiles(blockName) {
  const blockTitle = blockName
    .split('-')
    .map(w => w.charAt(0).toUpperCase() + w.slice(1))
    .join(' ');

  const blockFolder = path.join(blocksDir, blockName);
  const phpTemplate = `${blockName}.php`;
  const previewImage = 'preview.jpg';
  const scssFile = path.join(scssDir, `${blockName}.scss`);
  const scssClass = `.block--custom-layout__${blockName}`;

  // Only generate if block.json doesn't exist yet
  const blockJsonPath = path.join(blockFolder, 'block.json');
  if (fs.existsSync(blockJsonPath)) {
    console.log(`⚠️ Block already exists: ${blockName}`);
    return;
  }

  fs.mkdirSync(blockFolder, { recursive: true });

  // block.json
  const blockJson = {
    name: `acf/${blockName}`,
    title: blockTitle,
    description: `${blockTitle} block.`,
    category: 'custom-layout',
    icon: 'layout',
    keywords: [blockName],
    acf: {
      mode: 'preview',
      renderTemplate: `inc/acf-blocks/${blockName}/${phpTemplate}`
    },
    align: 'full',
    supports: { anchor: true },
    example: {
      attributes: {
        mode: 'preview',
        data: {
          preview_image: `inc/acf-blocks/${blockName}/${previewImage}`
        }
      }
    }
  };

  fs.writeFileSync(blockJsonPath, JSON.stringify(blockJson, null, 2));

  // PHP template
  const phpTemplateContent = `<?php
// Gutenberg Block Settings
$anchor_id = !empty($block['anchor']) ? 'id="' . esc_attr($block['anchor']) . '"' : '';
$background = get_field('background_color') ?: '#FFFFFF';
$theme = get_field('theme') ?: 'light';

// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'block--custom-layout__';
if ( ! empty( $block['className'] ) ) {
    $class_name .= ' ' . $block['className'];
}

// ACF fields
$bgColor = get_field('${blockName}_background_color');
?>

<div class="block--custom-layout <?= $class_name ?>" <?= $anchor_id ?> style="background-color: <?= esc_attr($bgColor) ?>;">
  <div class="container">
    <!-- Block Content -->
  </div>
</div>
`;

  fs.writeFileSync(path.join(blockFolder, phpTemplate), phpTemplateContent);

  // Empty preview.jpg
  fs.writeFileSync(path.join(blockFolder, previewImage), '');

  // SCSS file
  const scssContent = `/* ${blockTitle} Block Styles */\n${scssClass} {\n  padding: 100px 0;\n}\n`;
  fs.writeFileSync(scssFile, scssContent);

  // Append @import to _all.scss
  const importLine = `@import "${blockName}";`;

  if (!fs.existsSync(allScssPath)) {
    fs.writeFileSync(allScssPath, `//CUSTOM BLOCKS\n${importLine}\n`);
  } else {
    const content = fs.readFileSync(allScssPath, 'utf-8');
    const lines = content.split('\n');
    if (!content.includes(importLine)) {
      const customBlockIndex = lines.findIndex(line => line.trim() === '//CUSTOM BLOCKS');
      if (customBlockIndex !== -1) {
        lines.splice(customBlockIndex + 1, 0, importLine);
        fs.writeFileSync(allScssPath, lines.join('\n'));
      } else {
        fs.appendFileSync(allScssPath, `\n${importLine}\n`);
      }
    }
  }

  console.log(`✅ Block generated: ${blockName}`);
}

// Watch for new block folders
chokidar
  .watch(blocksDir, {
    depth: 0,
    ignoreInitial: true,
    awaitWriteFinish: true,
    persistent: true
  })
  .on('addDir', dirPath => {
    const blockName = path.basename(dirPath);
    if (blockName && blockName !== 'acf-blocks') {
      console.log(`📂 Detected new folder: ${blockName}`);
      generateBlockFiles(blockName);
    }
  });

console.log('👀 Watching inc/acf-blocks/ for new block folders...');
