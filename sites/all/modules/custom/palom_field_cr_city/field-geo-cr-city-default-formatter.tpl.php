<?php if (!empty($element['city_url'])): ?>
  <?php print l($element['city_name'], $element['city_url']); ?>
<?php else: ?>
  <?php print $element['city_name']; ?>
<?php endif; ?>
 (<?php print $element['country_name']; ?><?php if (!empty($element['region_name'])):?>, <?php print $element['region_name']; ?><?php endif; ?>)

