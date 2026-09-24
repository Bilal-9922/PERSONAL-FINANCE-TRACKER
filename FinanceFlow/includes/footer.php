</main>
</div>
<script src="assets/js/script.js"></script>
<?php if (isset($chart_data)): ?>
<script>
window.financeChartData = <?= json_encode($chart_data, JSON_UNESCAPED_UNICODE) ?>;
</script>
<script src="assets/js/charts.js"></script>
<?php endif; ?>
</body>
</html>
