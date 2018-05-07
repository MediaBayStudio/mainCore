<?php
/**
 * Шаблон подвала (footer.php)
 * @package WordPress
 * @subpackage your-clean-template-3
 */
?>
<footer class="page-footer">
  <div class="footer-info-wrapper">
    <div class="footer-info-main">
      <?php if(!dynamic_sidebar('footer')): ?>
        <p>Настроить можно в Панеле администратора - Внешний вид - Виджеты - Футер</p>
      <?php endif; ?>
    </div>
  </div>
  <div class="footer-copy-wrap">
    <div class="footer-copy">
      <?php if(!dynamic_sidebar('copywrite')): ?>
        <p>Настроить можно в Панеле администратора - Внешний вид - Виджеты - Копирайт</p>
      <?php endif; ?>
    </div>
  </div>
</footer>
<?php wp_footer(); // необходимо для работы плагинов и функционала  ?>
</body>
</html>
