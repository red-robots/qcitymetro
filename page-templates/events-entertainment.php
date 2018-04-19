<?php
/**
 * Template Name: Events & Entertainment
 */

get_header();?>
    <?php if ( have_posts() ) : the_post(); ?>
        <div id="primary" class="">
            <?php $banner_image = get_field("banner_image");
            $banner_copy = get_field("banner_copy");?>
            <div class="jobs-banner event-banner">
                <?php if($banner_image) echo '<div class="background" style="background-image: url('.$banner_image['url'].');"></div>';?>
                <?php if($banner_copy):?>
                    <div class="row-1">
                        <?php echo $banner_copy;?>
                    </div><!--.row-1-->
                <?php endif;?>
                <div class="row-2">
                    <a class="banner-button" href="<?php echo get_permalink(48786);?>">Post an Event</a>
                    <div class="banner-button find">Find an Event</div>
                </div><!--.row-1-->
                <div class="row-3">
                    <form action="<?php echo get_permalink();?>" method="GET">
                        <div class="row-1">
                            <input type="text" name="search" placeholder="Search">
                            <button type="submit">
                                <i class="fa fa-search"></i>
                            </button>
                            <div class="clear"></div>
                        </div><!--.row-1-->
                        <div class="row-2">
                            <?php $terms = get_field("categories_to_show");
                            if(is_array($terms)&&!empty($terms)):?>
                                <ul>
                                    <li>categories:</li>
                                    <?php foreach($terms as $term):?>
                                        <li>
                                            <input type="radio" name="category" id="<?php echo $term->slug;?>" value="<?php echo $term->term_id;?>"><label for="<?php echo $term->slug;?>"><?php echo $term->name;?></label>
                                        </li>
                                    <?php endforeach;?>
                                </ul>
                            <?php endif;?>
                        </div><!--.row-2-->
                        <div class="row-3">
                            <ul>
                                <li>date:</li>
                                <li>
                                    <input type="radio" name="date" id="date-today" value="today"><label for="date-today">today</label>
                                </li>
                                <li>
                                    <input type="radio" name="date" id="date-week" value="week"><label for="date-week">this week</label>
                                </li>
                                <li>
                                    <input type="radio" name="date" id="date-month" value="month"><label for="date-month">this month</label>
                                </li>
                                <li>
                                    <input type="radio" name="date" id="date-year" value="year"><label for="date-year">this year</label>
                                </li>
                            </ul>
                        </div><!--.row-3-->
                    </form>
                </div><!--.row-1-->
            </div><!--.event-banner-->
            <div id="content" role="main" class="wrapper">

                <div class="site-content">

                    <?php // for query of today and forward
                    $today = date('Ymd');
                    $future = null;
                    if(isset($_GET['date'])&&!empty($_GET['date'])):
                        $add = null;
                        if(strcmp($_GET['date'],'today')==0):
                            $add = 'P1D';
                        elseif(strcmp($_GET['date'],'week')==0):
                            $add = 'P7D';
                        elseif(strcmp($_GET['date'],'month')==0):
                            $add = 'P1M';
                        elseif(strcmp($_GET['date'],'year')==0):
                            $add = 'P1Y';
                        endif;
                        if($add!==null):
                            $enddate = new DateTime('NOW');
                            $enddate->add(new DateInterval($add));
                            $future = $enddate->format('Ymd');
                        endif;//if add not null
                    endif;//if for date set
                    
                    $args = array(
                        'post_type'=>'event',
                        'posts_per_page' => -1,
                        'orderby'=>'meta_value',
                        'meta_key'=>'event_date',
                        'order'=>'ASC'
                    );
                    $post__in = array();
                    if($future!==null):
                        //old queries for reference (didn't work generated from wordpress)

                        //LEFT JOIN qcqcq_postmeta ON ( qcqcq_posts.ID = qcqcq_postmeta.post_id ) LEFT JOIN qcqcq_postmeta AS mt1 ON ( qcqcq_posts.ID = mt1.post_id ) LEFT JOIN qcqcq_postmeta AS mt2 ON ( qcqcq_posts.ID = mt2.post_id ) LEFT JOIN qcqcq_postmeta AS mt3 ON ( qcqcq_posts.ID = mt3.post_id ) LEFT JOIN qcqcq_postmeta AS mt4 ON (qcqcq_posts.ID = mt4.post_id AND mt4.meta_key = 'event_date' ) LEFT JOIN qcqcq_postmeta AS mt5 ON ( qcqcq_posts.ID = mt5.post_id )

                        //AND ( ( ( qcqcq_postmeta.meta_key = 'event_date' AND qcqcq_postmeta.meta_value >= '20180419' ) AND ( mt1.meta_key = 'event_date' AND mt1.meta_value < '20180420' ) ) OR ( ( mt2.meta_key = 'event_date' AND mt2.meta_value < '20180419' ) AND ( mt3.meta_key = 'end_date' AND mt3.meta_value >= '20180420' ) ) OR mt4.post_id IS NULL OR ( mt5.meta_key = 'event_date' AND mt5.meta_value = '' ) )

                        $prepare_string = "SELECT DISTINCT ID FROM $wpdb->posts LEFT JOIN $wpdb->postmeta ON ( $wpdb->posts.ID = $wpdb->postmeta.post_id ) LEFT JOIN $wpdb->postmeta AS mt1 ON ( $wpdb->posts.ID = mt1.post_id ) WHERE ( ( ( $wpdb->postmeta.meta_key = 'event_date' AND $wpdb->postmeta.meta_value >= %d ) AND ( $wpdb->postmeta.meta_key = 'event_date' AND $wpdb->postmeta.meta_value < %d ) ) OR ( ( $wpdb->postmeta.meta_key = 'event_date' AND $wpdb->postmeta.meta_value < %d ) AND ( mt1.meta_key = 'end_date' AND mt1.meta_value >= %d ) ) )";
                        
                        $prepare_args = array();
                        array_unshift($prepare_args,$future);
                        array_unshift($prepare_args,$today);
                        array_unshift($prepare_args,$future);
                        array_unshift($prepare_args,$today);
                        array_unshift($prepare_args,$prepare_string);
                        $results = $wpdb->get_results( call_user_func_array(array($wpdb, "prepare"),$prepare_args) );
                        if($results):
                            foreach($results as $result):
                                $post__in[] = $result->ID;
                            endforeach;
                        else:
                            $post__in[] = -1;
                        endif;
                    else: 
                        //old queries for reference (generated from wordpress, worked, but bad)

                        //LEFT JOIN qcqcq_postmeta ON ( qcqcq_posts.ID = qcqcq_postmeta.post_id ) LEFT JOIN qcqcq_postmeta AS mt1 ON (qcqcq_posts.ID = mt1.post_id AND mt1.meta_key = 'event_date' )
                        //AND ( ( qcqcq_postmeta.meta_key = 'event_date' AND qcqcq_postmeta.meta_value >= '20180419' ) OR mt1.post_id IS NULL OR ( qcqcq_postmeta.meta_key = 'event_date' AND qcqcq_postmeta.meta_value = '' ) )*/
                        
                        $prepare_string = "SELECT DISTINCT ID FROM $wpdb->posts LEFT JOIN $wpdb->postmeta ON ( $wpdb->posts.ID = $wpdb->postmeta.post_id ) WHERE ( ( $wpdb->postmeta.meta_key = 'event_date' AND $wpdb->postmeta.meta_value >= %d ) OR ($wpdb->postmeta.meta_key = 'event_date' AND $wpdb->postmeta.meta_value = '' ) )";
                        
                        $prepare_args = array();
                        array_unshift($prepare_args,$today);
                        array_unshift($prepare_args,$prepare_string);
                        $results = $wpdb->get_results( call_user_func_array(array($wpdb, "prepare"),$prepare_args) );
                        if($results):
                            foreach($results as $result):
                                $post__in[] = $result->ID;
                            endforeach;
                        else:
                            $post__in[] = -1;
                        endif;
                    endif;
                    $temp__in = array();
                    if(isset($_GET['search'])&&!empty($_GET['search'])):
                        $prepare_string = "SELECT ID FROM $wpdb->posts WHERE post_title LIKE '%%%s%%' AND post_type = 'event' ";
                        $prepare_string .= "UNION SELECT object_id FROM $wpdb->term_relationships as r INNER JOIN $wpdb->terms as t ON t.term_id = r.term_taxonomy_id WHERE t.name LIKE '%%%s%%'";
                        $prepare_args[] = $_GET['search'];
                        array_unshift($prepare_args,$_GET['search']);
                        array_unshift($prepare_args,$prepare_string);
                        $results = $wpdb->get_results(  call_user_func_array(array($wpdb, "prepare"),$prepare_args));
                        if($results):
                            foreach($results as $result):
                                if(in_array($result->ID,$post__in)):
                                    $temp__in[] = $result->ID;
                                endif;
                            endforeach;
                        else: 
                            $temp__in[] = -1;
                        endif;
                    endif;
                    if(!empty($temp__in)):
                        $post__in = $temp__in;
                    endif;
                    if(isset($_GET['category'])&&!empty($_GET['category'])):
                        $args['meta_query'] = array(
                            'key'     => 'category',
                            'value'   => '"'.$_GET['category'].'"',
                            'compare' => 'LIKE'
                        );
                    endif;
                    $args['post__in']= $post__in;
                    $query = new WP_Query($args);
                    if ($query->have_posts()) :?>
                        <div class="tiles events"> 
                            <?php while ($query->have_posts()) :  $query->the_post(); 
                                $date = get_field("event_date");
                                $venue = get_field("name_of_venue");
                                $image = get_field("event_image");
                                $terms = wp_get_post_terms( get_the_ID(), 'event_category' );?>
                                <div class="tile">
                                    <div class="row-1">
                                        <?php if($image):?>
                                            <img src="<?php echo $image['sizes']['small'];?>" alt="<?php echo $image['alt'];?>">
                                        <?php endif;?>
                                        <h2><?php the_title();?></h2>
                                        <?php if($date):?>
                                            <div class="date">
                                                <?php echo $date;?>
                                            </div><!--.date-->
                                        <?php endif;
                                        if($venue):?>
                                            <div class="venue">
                                                <?php echo $venue;?>
                                            </div><!--.venue-->
                                        <?php endif;?>
                                    </div><!--.row-1-->
                                    <div class="row-2">
                                        <div class="col-1">
                                            <i class="fa fa-gears"></i>
                                        </div><!--.col-1-->
                                        <?php if(!is_wp_error($terms) && is_array($terms)&&!empty($terms)):?>
                                            <div class="col-2">
                                                <?php echo $terms[0]->name;?> 
                                            </div><!--.col-2-->
                                        <?php endif;?>
                                    </div><!--.row-2-->
                                </div><!--.tile-->
                            <?php endwhile;?>
                        </div><!--.tiles-->
                        <?php wp_reset_postdata();
                    endif;?> 
                </div><!-- site content -->
                
                <!-- 
                            Ad Zone

                ======================================================== -->        
                <div class="widget-area">
                    <?php 
                    //get_template_part('ads/right-big'); 
                    //get_template_part('ads/right-small');
                   // get_template_part('ads/right-rail');
                    ?>
                </div><!-- widget area -->
        
            </div><!-- #content -->
        </div><!-- #primary -->
    <?php endif; //main loop?>
<?php get_footer(); ?>