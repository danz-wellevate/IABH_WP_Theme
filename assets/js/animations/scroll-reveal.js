document.addEventListener('DOMContentLoaded', () => {
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

    const blocks = document.querySelectorAll('.block--custom-layout');
    if (!blocks.length) return;

    // Tag + class scoped on purpose — a bare ".header" also matches the
    // wrapper divs around repeater item titles (e.g. what-we-do's
    // objective items), which are not section headings.
    const headingSelector = 'h1, h2.header, h3.card-header, .header-paragraph h2';

    // Paragraph / body-copy wrappers (the actual "p tags" from ACF WYSIWYG fields).
    const paragraphSelector = '.sub-paragraph, .card-paragraph, .paragraph, .description-paragraph, .description';

    // Cards / boxes / repeater items.
    const boxSelector = '.key-points, .card-cta, .box-item, .legends-repeater .item, .report-repeater .item, .events-repeater .item, .partner-wrapper, .cta-wrapper, .illustration';

    blocks.forEach((block) => {
        const heading = block.querySelector(headingSelector);
        const paragraphs = block.querySelectorAll(paragraphSelector);
        const boxes = block.querySelectorAll(boxSelector);

        let inner = null;

        if (heading) {
            const mask = document.createElement('span');
            mask.className = 'curtain-reveal';

            inner = document.createElement('span');
            inner.className = 'curtain-reveal__inner';

            while (heading.firstChild) {
                inner.appendChild(heading.firstChild);
            }

            mask.appendChild(inner);
            heading.appendChild(mask);

            gsap.set(inner, { yPercent: 110, opacity: 0 });
        }

        if (paragraphs.length) gsap.set(paragraphs, { opacity: 0, y: 30 });
        if (boxes.length) gsap.set(boxes, { opacity: 0, y: 30 });

        if (!inner && !paragraphs.length && !boxes.length) return;

        // One timeline per block, triggered once as the block enters the
        // viewport, so the heading, paragraphs, and boxes all fade up in
        // sync rather than firing off independent scroll positions.
        const tl = gsap.timeline({
            scrollTrigger: {
                trigger: block,
                start: 'top 80%',
                once: true
            }
        });

        if (inner) {
            tl.to(inner, { yPercent: 0, opacity: 1, duration: 1, ease: 'power4.out' });
        }

        if (paragraphs.length) {
            tl.to(paragraphs, {
                opacity: 1,
                y: 0,
                duration: 0.8,
                ease: 'power3.out',
                stagger: 0.1
            }, inner ? '-=0.6' : 0);
        }

        if (boxes.length) {
            tl.to(boxes, {
                opacity: 1,
                y: 0,
                duration: 0.8,
                ease: 'power3.out',
                stagger: 0.12
            }, '-=0.5');
        }
    });
});
