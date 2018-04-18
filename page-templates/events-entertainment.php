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
                    $meta = array();
                    $meta_cat = null;
                    $meta_date = null;
                    if($future!==null):
                        $meta_date = array(
                            'relation'=>'AND',
                            array(
                                'key'=>'event_date',
                                'value'=>$today,
                                'compare'=>'>=',
                                'type'=>'NUMERIC'
                            ),
                            array(
                                'key'=>'event_date',
                                'value'=>$future,
                                'compare'=>'<',
                                'type'=>'NUMERIC'
                            )
                        );
                    else: 
                        $meta_date = array(
                            'relation'=>'OR',
                            array(
                                'key'=>'event_date',
                                'value'=>$today,
                                'compare'=>'>=',
                                'type'=>'NUMERIC'
                            ),
                            array(
                                'key'=>'event_date',
                                'compare' => 'NOT EXISTS'
                            )
                        );
                    endif;
                    if(isset($_GET['search'])&&!empty($_GET['search'])):
                        $prepare_string = "SELECT ID FROM $wpdb->posts WHERE post_title LIKE '%%%s%%' AND post_type = 'event' ";
                        $prepare_string .= "UNION SELECT object_id FROM $wpdb->term_relationships as r INNER JOIN $wpdb->terms as t ON t.term_id = r.term_taxonomy_id WHERE t.name LIKE '%%%s%%'";
                        $prepare_args[] = $_GET['search'];
                        array_unshift($prepare_args,$_GET['search']);
                        array_unshift($prepare_args,$prepare_string);
                        $results = $wpdb->get_results(  call_user_func_array(array($wpdb, "prepare"),$prepare_args));
                        $in = array();
                        if($results):
                            foreach($results as $result):
                                $in[] = $result->ID;
                            endforeach;
                        else:
                            $in[] = -1;
                        endif;
                        $args['post__in']= $in;
                    endif;
                    if(isset($_GET['category'])&&!empty($_GET['category'])):
                        $meta_cat = array(
                            'key'     => 'category',
                            'value'   => '"'.$_GET['category'].'"',
                            'compare' => 'LIKE'
                        );
                    endif;
                    $meta[] = $meta_date;
                    if(!empty($meta_cat)):
                        $meta[] = $meta_cat;
                    endif;
                    $args['meta_query'] = $meta;
                    var_dump($args);
                    $query = new WP_Query($args);
                    if ($query->have_posts()) : 
                        while ($query->have_posts()) :  $query->the_post(); ?>
                            <h1><?php the_title();?></h1>
                            <h2><?php echo get_field('event_date');?></h2> 
                        <?php endwhile;
                        wp_reset_postdata();
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