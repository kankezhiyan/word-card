 <?php
    global $wp_query;
    $total_pages = $wp_query->max_num_pages;
    $current_page = max(1, get_query_var('paged'));

    if ($total_pages > 1) {
        echo '<div class="paginator">';

        if ($current_page > 1) {
            echo '<a href="' . get_previous_posts_page_link() . '" class="page-number prev"><i class="fa fa-chevron-left"></i></a>';
        } else {
            echo '<span class="page-number prev disabled"><i class="fa fa-chevron-left"></i></span>';
        }

        echo '<a href="' . get_pagenum_link(1) . '" class="page-number' . ($current_page == 1 ? ' current' : '') . '">1</a>';

        $show_prev = $current_page - 1;
        $show_next = $current_page + 1;
        $need_left_ellipsis = $show_prev > 2;
        $need_right_ellipsis = $show_next < $total_pages - 1;

        if ($need_left_ellipsis) {
            echo '<span class="space">...</span>';
        }

        if ($show_prev > 1 && $show_prev < $total_pages) {
            echo '<a href="' . get_pagenum_link($show_prev) . '" class="page-number">' . $show_prev . '</a>';
        }

        if ($current_page != 1 && $current_page != $total_pages) {
            echo '<span class="page-number current">' . $current_page . '</span>';
        }

        if ($show_next > 1 && $show_next < $total_pages) {
            echo '<a href="' . get_pagenum_link($show_next) . '" class="page-number">' . $show_next . '</a>';
        }

        if ($need_right_ellipsis) {
            echo '<span class="space">...</span>';
        }

        echo '<a href="' . get_pagenum_link($total_pages) . '" class="page-number' . ($current_page == $total_pages ? ' current' : '') . '">' . $total_pages . '</a>';

        if ($current_page < $total_pages) {
            echo '<a href="' . get_next_posts_page_link() . '" class="page-number next"><i class="fa fa-chevron-right"></i></a>';
        } else {
            echo '<span class="page-number next disabled"><i class="fa fa-chevron-right"></i></span>';
        }

        echo '<div class="page-jump">';
        echo '<span class="page-jump-label">跳至第</span>';
        echo '<input type="number" class="page-jump-input" min="1" max="' . $total_pages . '" value="' . $current_page . '">';
        echo '<span class="page-jump-label">页</span>';
        echo '<button type="button" class="page-jump-go">';
        echo '<i class="fa fa-arrow-right"></i>';
        echo '</button>';
        echo '</div>';

        echo '</div>';
    }
    ?>