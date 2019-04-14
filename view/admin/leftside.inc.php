<div id="sidebar" class="sidebar                  responsive">
    <script type="text/javascript">
        try{ace.settings.check('sidebar' , 'fixed')}catch(e){}
    </script>
    <ul class="nav nav-list">
        <?php
            $menus = MENU();
            $html = '';
            foreach($menus as $k => $v) {

                if(count($v['methods']) == 1) {
                    $_k = array_keys($v['methods'])[0];
                    $_v = array_shift($v['methods']);
                    $class = getClass() == $k && getAction() == $_k ? 'open' : '';
                    $html .= '<li class="' . $class.'"><a href="' . $_v['url'].'"><i class="menu-icon fa ' . $v['icon'].'"></i>';
                    $html .= '<span class="menu-text">'.$_v['title'].' </span></a>';
                    $html .= '<b class="arrow"></b></li>';
                }else {
                    $class = getClass() == $k ? 'open' : '';
                    $html .= '<li class="'.$class . '">';
                    $html .= '<a href="#" class="dropdown-toggle">';
                    $html .= '<i class="menu-icon fa ' . $v['icon'] . '"></i>';
                    $html .= '<span class="menu-text">'.$v['title'].' </span>';
                    $html .= '<b class="arrow fa fa-angle-down"></b>';
                    $html .= '</a><b class="arrow"></b>';
                    $html .= display_sub_menu($v['methods'], $k);
                    $html .= '</li>';
                }
            }
            echo $html;
        ?>

    </ul><!-- /.nav-list -->

    <!-- #section:basics/sidebar.layout.minimize -->
    <div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
        <i class="ace-icon fa fa-angle-double-left" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
    </div>

    <!-- /section:basics/sidebar.layout.minimize -->
    <script type="text/javascript">
        try{ace.settings.check('sidebar' , 'collapsed')}catch(e){}
    </script>
</div>