// document.addEventListener('DOMContentLoaded', function () {

//   function applyBleed() {
//     const vw = document.documentElement.clientWidth;
//     console.log('[applyBleed] vw:', vw);

//     document.querySelectorAll('.block--custom-layout__two-column-text-image').forEach((block, i) => {
//       const container  = block.querySelector('.container');
//       const wrapper    = block.querySelector('.two-column__wrapper');
//       const imgContent = block.querySelector('.two-column__image-content');

//       if (!container || !wrapper || !imgContent) return;

//       const isRight = wrapper.classList.contains('image-right');
//       const isLeft  = wrapper.classList.contains('image-left');
//       if (!isRight && !isLeft) return;

//       const cr = container.getBoundingClientRect(); // container rect
//       console.log(`[#${i}] container: left=${Math.round(cr.left)} right=${Math.round(cr.right)} width=${Math.round(cr.width)}`);

//       // The content midpoint — where the image column starts/ends
//       const midpoint = cr.left + cr.width / 2;
//       console.log(`[#${i}] midpoint: ${Math.round(midpoint)}px`);

//       if (isRight) {
//         // Image starts at midpoint, ends at vw
//         const imgWidth = vw - midpoint;
//         // In px relative to the container, how far left is the midpoint from container left
//         const offsetFromContainerLeft = cr.width / 2;

//         imgContent.style.setProperty('--img-width',  imgWidth + 'px',  'important');
//         imgContent.style.setProperty('--img-offset', offsetFromContainerLeft + 'px', 'important');

//         console.log(`[#${i}] image-right → width=${Math.round(imgWidth)}px offset=${Math.round(offsetFromContainerLeft)}px`);
//         console.log(`[#${i}] image-right → should reach right edge: midpoint(${Math.round(midpoint)}) + width(${Math.round(imgWidth)}) = ${Math.round(midpoint + imgWidth)} vs vw(${vw})`);
//       }

//       if (isLeft) {
//         // Image starts at 0, ends at midpoint
//         const imgWidth = midpoint;
//         // How far to pull left = distance from container left to viewport left
//         const pullLeft = cr.left;

//         imgContent.style.setProperty('--img-width',    imgWidth + 'px', 'important');
//         imgContent.style.setProperty('--img-pull-left', pullLeft + 'px', 'important');

//         console.log(`[#${i}] image-left → width=${Math.round(imgWidth)}px pullLeft=${Math.round(pullLeft)}px`);
//         console.log(`[#${i}] image-left → should reach left edge: containerLeft(${Math.round(cr.left)}) - pullLeft(${Math.round(pullLeft)}) = ${Math.round(cr.left - pullLeft)}`);
//       }
//     });
//   }

//   applyBleed();
//   window.addEventListener('load', applyBleed);
//   setTimeout(applyBleed, 300);
//   setTimeout(applyBleed, 1000);

//   let t;
//   window.addEventListener('resize', function () {
//     clearTimeout(t);
//     t = setTimeout(applyBleed, 100);
//   });
// });