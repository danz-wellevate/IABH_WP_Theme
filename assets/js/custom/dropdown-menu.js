document.addEventListener('DOMContentLoaded', function () {
	document.querySelectorAll('[data-navigator-dropdown]').forEach(function (wrap) {
		var toggle      = wrap.querySelector('[data-navigator-toggle]');
		var menu        = wrap.querySelector('[data-navigator-menu]');
		var labelEl     = toggle ? toggle.querySelector('.navigator-toggle-label') : null;
		var defaultLabel = labelEl ? (labelEl.getAttribute('data-navigator-default-label') || labelEl.textContent) : '';

		if (!toggle || !menu || !labelEl) return;

		function closeMenu() {
			wrap.classList.remove('is-open');
			toggle.setAttribute('aria-expanded', 'false');
		}

		function openMenu() {
			wrap.classList.add('is-open');
			toggle.setAttribute('aria-expanded', 'true');
		}

		function setLabel(text) {
			labelEl.textContent = text;
		}

		toggle.addEventListener('click', function (e) {
			e.stopPropagation();
			wrap.classList.contains('is-open') ? closeMenu() : openMenu();
		});

		document.addEventListener('click', function (e) {
			if (!wrap.contains(e.target)) closeMenu();
		});

		document.addEventListener('keydown', function (e) {
			if (e.key === 'Escape') closeMenu();
		});

		// ---- Build a map of sectionId -> { link, label, el } for every in-page anchor link ----
		var sectionLinks = []; // ordered list, keeps document order for scroll-spy fallback logic

		menu.querySelectorAll('a').forEach(function (link) {
			var href = link.getAttribute('href') || '';
			var hashIndex = href.indexOf('#');

			if (hashIndex === -1) return; // normal link to another page, leave alone

			var targetId   = href.slice(hashIndex + 1);
			var pathBefore = href.slice(0, hashIndex);
			var isSamePage = pathBefore === '' ||
				pathBefore === window.location.pathname ||
				pathBefore === window.location.href.split('#')[0];

			if (!targetId || !isSamePage) return;

			var targetEl = document.getElementById(targetId);
			if (!targetEl) return; // no matching section on this page, let it navigate normally

			sectionLinks.push({
				id:    targetId,
				link:  link,
				label: (link.textContent || '').trim(),
				el:    targetEl
			});

			link.addEventListener('click', function (e) {
				e.preventDefault();

				var header       = document.getElementById('wrapper-navbar');
				var headerHeight = header ? header.offsetHeight : 0;
				var extraGap     = 20; // breathing room below the header
				var targetTop    = targetEl.getBoundingClientRect().top + window.pageYOffset - headerHeight - extraGap;

				window.scrollTo({ top: targetTop, behavior: 'smooth' });

				// Update the label immediately so it doesn't wait on the scroll-spy.
				setLabel((link.textContent || '').trim());
				wrap.setAttribute('data-navigator-active', targetId);

				closeMenu();
				history.pushState(null, '', '#' + targetId);
			});
		});

		// ---- Scroll-spy: highlight/label whichever section is currently in view ----
		if (sectionLinks.length && 'IntersectionObserver' in window) {

			var header       = document.getElementById('wrapper-navbar');
			var headerHeight = header ? header.offsetHeight : 0;

			// A thin horizontal band just below the sticky header — the section
			// crossing this line is considered "active".
			var topMargin    = -(headerHeight + 10);
			var bottomMargin = -(Math.max(window.innerHeight - headerHeight - 10 - 150, 0));

			var currentActiveId = null;

			var observer = new IntersectionObserver(function (entries) {
				entries.forEach(function (entry) {
					var match = sectionLinks.find(function (s) { return s.el === entry.target; });
					if (!match) return;

					if (entry.isIntersecting) {
						currentActiveId = match.id;
						setLabel(match.label);
						wrap.setAttribute('data-navigator-active', match.id);

						sectionLinks.forEach(function (s) {
							s.link.classList.toggle('is-active', s.id === match.id);
						});
					}
				});

				// If nothing is intersecting (e.g. above the very first section),
				// fall back to the default label.
				var anyIntersecting = sectionLinks.some(function (s) {
					return s.el.getBoundingClientRect().top < (headerHeight + 10) &&
						   s.el.getBoundingClientRect().bottom > (headerHeight + 10);
				});
				if (!anyIntersecting && window.scrollY < 100) {
					currentActiveId = null;
					setLabel(defaultLabel);
					wrap.removeAttribute('data-navigator-active');
					sectionLinks.forEach(function (s) { s.link.classList.remove('is-active'); });
				}
			}, {
				root: null,
				rootMargin: topMargin + 'px 0px ' + bottomMargin + 'px 0px',
				threshold: 0
			});

			sectionLinks.forEach(function (s) { observer.observe(s.el); });

			// Recompute margins on resize (header height / viewport can change).
			window.addEventListener('resize', function () {
				headerHeight = header ? header.offsetHeight : 0;
				topMargin    = -(headerHeight + 10);
				bottomMargin = -(Math.max(window.innerHeight - headerHeight - 10 - 150, 0));
				observer.disconnect();
				var newObserver = new IntersectionObserver(observer.callback || function(){}, {
					root: null,
					rootMargin: topMargin + 'px 0px ' + bottomMargin + 'px 0px',
					threshold: 0
				});
				sectionLinks.forEach(function (s) { newObserver.observe(s.el); });
				observer = newObserver;
			});

			// If the page loads with a hash already in the URL, set the label immediately.
			if (window.location.hash) {
				var initialId = window.location.hash.slice(1);
				var initialMatch = sectionLinks.find(function (s) { return s.id === initialId; });
				if (initialMatch) {
					setLabel(initialMatch.label);
					wrap.setAttribute('data-navigator-active', initialMatch.id);
				}
			}
		}
	});
});