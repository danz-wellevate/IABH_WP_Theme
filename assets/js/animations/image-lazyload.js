import 'lazysizes';
import 'lazysizes/plugins/parent-fit/ls.parent-fit';
import 'lazysizes/plugins/unveilhooks/ls.unveilhooks';
import 'lazysizes/plugins/bgset/ls.bgset';

document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('img:not(.lazyload)').forEach(img => {
    if (!img.src) return;

    img.dataset.src = img.src;
    img.removeAttribute('src');
    img.classList.add('lazyload');
  });

  // 🔴 REQUIRED
  if (window.lazySizes) {
    lazySizes.loader.checkElems();
  }
});
