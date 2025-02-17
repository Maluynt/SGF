<aside class="col-md-3 sidebar bg-dark text-white">
    <div class="sidebar-sticky">
        <ul class="list-group list-group-flush">
            <?php foreach(get_sidebar_config() as $itemKey => $menuItem): ?>
                <?php if(isset($menuItem['submenu'])): ?>
                    <!-- Elementos con submenú -->
                    <li class="list-group-item dropdown <?= is_menu_active($itemKey) ? 'active' : '' ?>">
                        <a href="#" class="menu-item dropdown-toggle" data-toggle="dropdown">
                            <i class="<?= $menuItem['icon'] ?> mr-2"></i>
                            <?= htmlspecialchars($menuItem['title']) ?>
                        </a>
                        <ul class="dropdown-menu">
                            <?php foreach($menuItem['submenu'] as $subKey => $subItem): ?>
                                <li>
                                    <a class="dropdown-item <?= is_submenu_active($subKey) ? 'active' : '' ?>" 
                                       href="<?= $subItem['link'] ?? '#' ?>">
                                        <i class="<?= $subItem['icon'] ?> mr-2"></i>
                                        <?= htmlspecialchars($subItem['title']) ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </li>
                <?php else: ?>
                    <!-- Elementos simples -->
                    <li class="list-group-item <?= is_menu_active($itemKey) ? 'active' : '' ?>">
                        <a href="<?= $menuItem['link'] ?? '#' ?>" 
                           class="menu-item <?= $menuItem['class'] ?? '' ?>">
                            <i class="<?= $menuItem['icon'] ?> mr-2"></i>
                            <?= htmlspecialchars($menuItem['title']) ?>
                        </a>
                    </li>
                <?php endif; ?>
            <?php endforeach; ?>
        </ul>
    </div>
</aside>