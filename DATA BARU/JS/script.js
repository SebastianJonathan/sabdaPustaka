<script>
		const filter_sm = document.getElementById('filter-sm');

		function hideFilterSM() {
				let openedCanvas = bootstrap.Offcanvas.getInstance(filter_sm);
				try {
						openedCanvas.hide();
						// document.activeElement.blur();
				} catch {}
		}
		window.addEventListener('resize', hideFilterSM);
</script>