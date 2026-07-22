document.addEventListener('DOMContentLoaded', () => {
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

    const blocks = document.querySelectorAll('.block--custom-layout');
    if (!blocks.length) return;

    // ".header" and "h1" are the section headings (home-hero uses a bare
    // h1 with no ".header" class); the rest are the body-copy / text
    // wrappers used across the ACF blocks (subheadings, WYSIWYG
    // paragraphs, item descriptions).
    const headingSelector = '.header, h1';

    // ".description" is intentionally left out — it only ever appears
    // nested inside a ".legends-repeater .item" box below, and animating
    // both the item and its own child fights the parent's opacity tween
    // (a child can't render above its parent's opacity), so the text pops
    // in instead of fading with the box.
    const textSelector = '.sub-paragraph, .card-paragraph, .paragraph, .description-paragraph, .subheader';

    // Cards / boxes / repeater items — the "column" style content across
    // the blocks (partner logos, report cards, event cards, objectives).
    const boxSelector = '.box-item, .legends-repeater .item, .report-repeater .item, .events-repeater .item, .illustration, .key-points, .card-cta, .cta-wrapper';

    blocks.forEach((block) => {
        const heading = block.querySelector(headingSelector);
        const textEls = block.querySelectorAll(textSelector);
        const boxEls = block.querySelectorAll(boxSelector);

        if (!heading && !textEls.length && !boxEls.length) return;

        if (heading) gsap.set(heading, { opacity: 0, y: 30 });
        if (textEls.length) gsap.set(textEls, { opacity: 0, y: 30 });
        if (boxEls.length) gsap.set(boxEls, { opacity: 0, y: 30 });

        // One timeline per block, triggered once as the block enters the
        // viewport, so the heading, its body text, and its boxes fade up
        // together as a sequence instead of each firing at its own
        // scroll position.
        const tl = gsap.timeline({
            scrollTrigger: {
                trigger: block,
                start: 'top 80%',
                once: true
            }
        });

        if (heading) {
            tl.to(heading, { opacity: 1, y: 0, duration: 0.8, ease: 'power3.out' });
        }

        if (textEls.length) {
            tl.to(textEls, {
                opacity: 1,
                y: 0,
                duration: 0.8,
                ease: 'power3.out',
                stagger: 0.1
            }, heading ? '-=0.5' : 0);
        }

        if (boxEls.length) {
            tl.to(boxEls, {
                opacity: 1,
                y: 0,
                duration: 0.8,
                ease: 'power3.out',
                stagger: 0.12
            }, '-=0.5');
        }
    });
});
