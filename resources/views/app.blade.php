<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
		<script>
		(function() { // -- start darkmode before render -- //
			const savedTheme = localStorage.getItem('theme');
			const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
			if (savedTheme === 'dark' || (!savedTheme && prefersDark)) {
				document.documentElement.classList.add('dark');
			}
		})();
		</script>
		@vite('resources/css/app.css')
		@vite('resources/js/app.js')
		@inertiaHead
		@routes
	</head>
	<body class="bg-stone-200 dark:bg-stone-900">
		@inertia
	</body>
</html>