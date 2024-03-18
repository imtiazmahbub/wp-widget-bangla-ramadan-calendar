<?php
/*
Plugin Name: Iftar Time 2024
Plugin URI: https://buildit.com.bd
Description: Display Ramadan Sahri and Iftar time in Bangla for the year 2024
Version: 0.1-alpha
Author: Build it
Author URI: https://buildit.com.bd
License: GPL2
*/

class IftarTime2024_Widget extends WP_Widget {

	// Main constructor
	public function __construct() {
		parent::__construct(
			'iftar_time2024_widget',
			__( 'Iftar Time 2024 Widget', 'text_domain' ),
			array(
				'customize_selective_refresh' => true,
			)
		);
	}

	// The widget form (for the backend )
	public function form( $instance ) {	

        // Set widget defaults
        $defaults = array(
            'title'    => '',
            'checkbox' => '',
        );
        
        // Parse current settings with defaults
        extract( wp_parse_args( ( array ) $instance, $defaults ) ); ?>

        <?php // Widget Title ?>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Widget Title', 'text_domain' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>

		<?php // Checkbox ?>
		<p>
			<input id="<?php echo esc_attr( $this->get_field_id( 'checkbox' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'checkbox' ) ); ?>" type="checkbox" value="1" <?php checked( '1', $checkbox ); ?> />
			<label for="<?php echo esc_attr( $this->get_field_id( 'checkbox' ) ); ?>"><?php _e( 'Display Calendar?', 'text_domain' ); ?></label>
		</p>

    <?php }

	// Update widget settings
	public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title']    = isset( $new_instance['title'] ) ? wp_strip_all_tags( $new_instance['title'] ) : '';
		$instance['checkbox'] = isset( $new_instance['checkbox'] ) ? 1 : false;
        return $instance;
	}

	// Display the widget
	public function widget( $args, $instance ) {
        extract( $args );
    
        // Check the widget options
        $title    = isset( $instance['title'] ) ? apply_filters( 'widget_title', $instance['title'] ) : '';
		$checkbox = ! empty( $instance['checkbox'] ) ? $instance['checkbox'] : false;

        $data = json_decode('{"2024-03-12":{"Ramadan":1,"Sahri":"04:52","Iftar":"18:10"},"2024-03-13":{"Ramadan":2,"Sahri":"04:52","Iftar":"18:11"},"2024-03-14":{"Ramadan":3,"Sahri":"04:52","Iftar":"18:11"},"2024-03-15":{"Ramadan":4,"Sahri":"04:49","Iftar":"18:12"},"2024-03-16":{"Ramadan":5,"Sahri":"04:49","Iftar":"18:12"},"2024-03-17":{"Ramadan":6,"Sahri":"04:49","Iftar":"18:12"},"2024-03-18":{"Ramadan":7,"Sahri":"04:46","Iftar":"18:13"},"2024-03-19":{"Ramadan":8,"Sahri":"04:46","Iftar":"18:13"},"2024-03-20":{"Ramadan":9,"Sahri":"04:46","Iftar":"18:13"},"2024-03-21":{"Ramadan":10,"Sahri":"04:43","Iftar":"18:14"},"2024-03-22":{"Ramadan":11,"Sahri":"04:43","Iftar":"18:14"},"2024-03-23":{"Ramadan":12,"Sahri":"04:43","Iftar":"18:14"},"2024-03-24":{"Ramadan":13,"Sahri":"04:40","Iftar":"18:15"},"2024-03-25":{"Ramadan":14,"Sahri":"04:40","Iftar":"18:15"},"2024-03-26":{"Ramadan":15,"Sahri":"04:39","Iftar":"18:16"},"2024-03-27":{"Ramadan":16,"Sahri":"04:35","Iftar":"18:16"},"2024-03-28":{"Ramadan":17,"Sahri":"04:35","Iftar":"18:17"},"2024-03-29":{"Ramadan":18,"Sahri":"04:35","Iftar":"18:17"},"2024-03-30":{"Ramadan":19,"Sahri":"04:31","Iftar":"18:18"},"2024-03-31":{"Ramadan":20,"Sahri":"04:31","Iftar":"18:18"},"2024-04-01":{"Ramadan":21,"Sahri":"04:29","Iftar":"18:19"},"2024-04-02":{"Ramadan":22,"Sahri":"04:29","Iftar":"18:19"},"2024-04-03":{"Ramadan":23,"Sahri":"04:27","Iftar":"18:19"},"2024-04-04":{"Ramadan":24,"Sahri":"04:27","Iftar":"18:20"},"2024-04-05":{"Ramadan":25,"Sahri":"04:27","Iftar":"18:20"},"2024-04-06":{"Ramadan":26,"Sahri":"04:24","Iftar":"18:21"},"2024-04-07":{"Ramadan":27,"Sahri":"04:24","Iftar":"18:21"},"2024-04-08":{"Ramadan":28,"Sahri":"04:24","Iftar":"18:21"},"2024-04-09":{"Ramadan":29,"Sahri":"04:21","Iftar":"18:22"},"2024-04-10":{"Ramadan":30,"Sahri":"04:21","Iftar":"18:22"}}', false);
    
        // WordPress core before_widget hook (always include )
        echo $before_widget;
    
        // Display the widget
        ?>
        <div class="left relative mvp-widget-feat2-side">
            <div style="background: url(https://bayanno.com/wp-content/uploads/2024/03/islamic-bg-small.jpg); border: 1px solid #e0e0e0;">
                <div style="margin-bottom:1em">
                    <img src="https://bayanno.com/wp-content/uploads/2024/03/ramadan-small.webp" width="100%">
                </div>
                <div style="display: flex;flex-direction: column;align-items: center;gap: 10px;margin-top: 1em;margin-bottom: 1em;">
                    <div>সাহরি ও ইফতারের সময়সূচি </div>
                    <div>
                        <?php if(!empty($data->{date('Y-m-d')})): ?>
                            <?php
                            $date = date('Y-m-d');
                            $dateData = $data->{date('Y-m-d')};
                            $iftar = date("g:i", strtotime($date ." ". $dateData->Iftar ." UTC"));
                            $sahri = date("g:i", strtotime($date ." ". $dateData->Sahri ." UTC"));
                            ?>
                        <span><?= $this->bn_translate_number($dateData->Ramadan) ?> রমজান </span> |
                        <?php endif; ?>
                        <span><?= $this->bn_translate_number(date('d')) ?> <?= $this->bn_translate_month(date('M')) ?> <?= $this->bn_translate_day(date('l')) ?> </span>
                    </div>
                        <div style="display: flex;flex-direction: column;align-items: center;gap: 1em;margin-top: 1em;border: 1px solid #EEEEEE;padding: 1em 1.5em 0 1.5em;">
                            <h3>আজকের সময়সূচী</h3>
                            <table class="table table-condensed">
                                <tr>
                                    <th>সাহরি</th>
                                    <th>ইফতার</th>
                                </tr>
                                <tr>
                                    <td>ভোর <?= $this->bn_translate_number($iftar) ?> মিনিট</td>
                                    <td>সন্ধ্যা <?= $this->bn_translate_number($sahri) ?> মিনিট</td>
                                </tr>

                            </table>
                        </div>
                    <?php if(!empty($data->{date('Y-m-d', strtotime(' +1 day'))})): ?>
                        <?php
                            $nextDay = date('Y-m-d', strtotime(' +1 day'));
                            $nextDateData = $data->{$nextDay};
                            $nextIftar = date("g:i", strtotime($date ." ". $nextDateData->Iftar ." UTC"));
                            $nextSahri = date("g:i", strtotime($date ." ". $nextDateData->Sahri ." UTC"));
                        ?>
                        <div style="display: flex;flex-direction: column;align-items: center;gap: 1em;margin-top: 1em;border: 1px solid #EEEEEE;padding: 1em 1.5em 0 1.5em;">
                            <h3>আগামীকালের সময়সূচী</h3>
                            <table class="table table-condensed">
                                <tr>
                                    <th>সাহরি</th>
                                    <th>ইফতার</th>
                                </tr>
                                <tr>
                                    <td>ভোর <?= $this->bn_translate_number($nextIftar) ?> মিনিট</td>
                                    <td>সন্ধ্যা <?= $this->bn_translate_number($nextSahri) ?> মিনিট</td>
                                </tr>

                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php if($checkbox): ?>
            <div style="display: flex; flex-direction: column; align-items: stretch; text-align: center;">
                <h3 style="margin: 1em 0;">রমজান ক্যালেন্ডার ২০২৪</h3>
                <div style="max-height: 350px;overflow-y: auto;">
                    <table class="table table-bordered table-condensed table-hover table-responsive table-striped" style="font-size:small;">
                        <thead>
                            <tr>
                                <th>তারিখ</th>
                                <th>সাহরি</th>
                                <th>ইফতার</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($data as $date=>$d): ?>
                            <tr>
                                <td><?= $date ?></td>
                                <td><?= $d->Sahri ?></td>
                                <td><?= $d->Iftar ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php endif; ?>
        </div>
        <style>
        .table{width:100%;max-width:100%;margin-bottom:20px}.table>thead>tr>th,.table>tbody>tr>th,.table>tfoot>tr>th,.table>thead>tr>td,.table>tbody>tr>td,.table>tfoot>tr>td{padding:8px;line-height:1.42857143;vertical-align:top;border-top:1px solid #ddd}.table>thead>tr>th{vertical-align:bottom;border-bottom:2px solid #ddd}.table>caption+thead>tr:first-child>th,.table>colgroup+thead>tr:first-child>th,.table>thead:first-child>tr:first-child>th,.table>caption+thead>tr:first-child>td,.table>colgroup+thead>tr:first-child>td,.table>thead:first-child>tr:first-child>td{border-top:0}.table>tbody+tbody{border-top:2px solid #ddd}.table .table{background-color:#fff}.table-condensed>thead>tr>th,.table-condensed>tbody>tr>th,.table-condensed>tfoot>tr>th,.table-condensed>thead>tr>td,.table-condensed>tbody>tr>td,.table-condensed>tfoot>tr>td{padding:5px}.table-bordered{border:1px solid #ddd}.table-bordered>thead>tr>th,.table-bordered>tbody>tr>th,.table-bordered>tfoot>tr>th,.table-bordered>thead>tr>td,.table-bordered>tbody>tr>td,.table-bordered>tfoot>tr>td{border:1px solid #ddd}.table-bordered>thead>tr>th,.table-bordered>thead>tr>td{border-bottom-width:2px}.table-striped>tbody>tr:nth-of-type(odd){background-color:#f9f9f9}.table-hover>tbody>tr:hover{background-color:#f5f5f5}.table>thead>tr>td.active,.table>tbody>tr>td.active,.table>tfoot>tr>td.active,.table>thead>tr>th.active,.table>tbody>tr>th.active,.table>tfoot>tr>th.active,.table>thead>tr.active>td,.table>tbody>tr.active>td,.table>tfoot>tr.active>td,.table>thead>tr.active>th,.table>tbody>tr.active>th,.table>tfoot>tr.active>th{background-color:#f5f5f5}.table-hover>tbody>tr>td.active:hover,.table-hover>tbody>tr>th.active:hover,.table-hover>tbody>tr.active:hover>td,.table-hover>tbody>tr:hover>.active,.table-hover>tbody>tr.active:hover>th{background-color:#e8e8e8}.table>thead>tr>td.success,.table>tbody>tr>td.success,.table>tfoot>tr>td.success,.table>thead>tr>th.success,.table>tbody>tr>th.success,.table>tfoot>tr>th.success,.table>thead>tr.success>td,.table>tbody>tr.success>td,.table>tfoot>tr.success>td,.table>thead>tr.success>th,.table>tbody>tr.success>th,.table>tfoot>tr.success>th{background-color:#dff0d8}.table-hover>tbody>tr>td.success:hover,.table-hover>tbody>tr>th.success:hover,.table-hover>tbody>tr.success:hover>td,.table-hover>tbody>tr:hover>.success,.table-hover>tbody>tr.success:hover>th{background-color:#d0e9c6}.table>thead>tr>td.info,.table>tbody>tr>td.info,.table>tfoot>tr>td.info,.table>thead>tr>th.info,.table>tbody>tr>th.info,.table>tfoot>tr>th.info,.table>thead>tr.info>td,.table>tbody>tr.info>td,.table>tfoot>tr.info>td,.table>thead>tr.info>th,.table>tbody>tr.info>th,.table>tfoot>tr.info>th{background-color:#d9edf7}.table-hover>tbody>tr>td.info:hover,.table-hover>tbody>tr>th.info:hover,.table-hover>tbody>tr.info:hover>td,.table-hover>tbody>tr:hover>.info,.table-hover>tbody>tr.info:hover>th{background-color:#c4e3f3}.table>thead>tr>td.warning,.table>tbody>tr>td.warning,.table>tfoot>tr>td.warning,.table>thead>tr>th.warning,.table>tbody>tr>th.warning,.table>tfoot>tr>th.warning,.table>thead>tr.warning>td,.table>tbody>tr.warning>td,.table>tfoot>tr.warning>td,.table>thead>tr.warning>th,.table>tbody>tr.warning>th,.table>tfoot>tr.warning>th{background-color:#fcf8e3}.table-hover>tbody>tr>td.warning:hover,.table-hover>tbody>tr>th.warning:hover,.table-hover>tbody>tr.warning:hover>td,.table-hover>tbody>tr:hover>.warning,.table-hover>tbody>tr.warning:hover>th{background-color:#faf2cc}.table>thead>tr>td.danger,.table>tbody>tr>td.danger,.table>tfoot>tr>td.danger,.table>thead>tr>th.danger,.table>tbody>tr>th.danger,.table>tfoot>tr>th.danger,.table>thead>tr.danger>td,.table>tbody>tr.danger>td,.table>tfoot>tr.danger>td,.table>thead>tr.danger>th,.table>tbody>tr.danger>th,.table>tfoot>tr.danger>th{background-color:#f2dede}.table-hover>tbody>tr>td.danger:hover,.table-hover>tbody>tr>th.danger:hover,.table-hover>tbody>tr.danger:hover>td,.table-hover>tbody>tr:hover>.danger,.table-hover>tbody>tr.danger:hover>th{background-color:#ebcccc}.table-responsive{min-height:.01%;overflow-x:auto}@media screen and (max-width:767px){.table-responsive{width:100%;margin-bottom:15px;overflow-y:hidden;-ms-overflow-style:-ms-autohiding-scrollbar;border:1px solid #ddd}.table-responsive>.table{margin-bottom:0}.table-responsive>.table>thead>tr>th,.table-responsive>.table>tbody>tr>th,.table-responsive>.table>tfoot>tr>th,.table-responsive>.table>thead>tr>td,.table-responsive>.table>tbody>tr>td,.table-responsive>.table>tfoot>tr>td{white-space:nowrap}.table-responsive>.table-bordered{border:0}.table-responsive>.table-bordered>thead>tr>th:first-child,.table-responsive>.table-bordered>tbody>tr>th:first-child,.table-responsive>.table-bordered>tfoot>tr>th:first-child,.table-responsive>.table-bordered>thead>tr>td:first-child,.table-responsive>.table-bordered>tbody>tr>td:first-child,.table-responsive>.table-bordered>tfoot>tr>td:first-child{border-left:0}.table-responsive>.table-bordered>thead>tr>th:last-child,.table-responsive>.table-bordered>tbody>tr>th:last-child,.table-responsive>.table-bordered>tfoot>tr>th:last-child,.table-responsive>.table-bordered>thead>tr>td:last-child,.table-responsive>.table-bordered>tbody>tr>td:last-child,.table-responsive>.table-bordered>tfoot>tr>td:last-child{border-right:0}.table-responsive>.table-bordered>tbody>tr:last-child>th,.table-responsive>.table-bordered>tfoot>tr:last-child>th,.table-responsive>.table-bordered>tbody>tr:last-child>td,.table-responsive>.table-bordered>tfoot>tr:last-child>td{border-bottom:0}}.clearfix:before,.clearfix:after,.container:before,.container:after,.container-fluid:before,.container-fluid:after,.row:before,.row:after{display:table;content:" "}.clearfix:after,.container:after,.container-fluid:after,.row:after{clear:both}.center-block{display:block;margin-right:auto;margin-left:auto}.pull-right{float:right !important}.pull-left{float:left !important}.hide{display:none !important}.show{display:block !important}.invisible{visibility:hidden}.text-hide{font:0/0 a;color:transparent;text-shadow:none;background-color:transparent;border:0}.hidden{display:none !important}.affix{position:fixed}
        </style>

        <?php
    
        // WordPress core after_widget hook (always include )
        echo $after_widget;
	}


    public function bn_translate_number( $str ) {
        $en = array( 0, 1, 2, 3, 4, 5, 6, 7, 8, 9 );
        $bn = array( '০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯' );

        $str = str_replace( $en, $bn, $str );

        return $str;
    }
    
    public function bn_translate_month( $str ) {
        $en = array( 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December' );
        $en_short = array( 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'June', 'July', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec' );
        $bn = array( 'জানুয়ারি', 'ফেব্রুয়ারি', 'মার্চ', 'এপ্রিল', 'মে', 'জুন', 'জুলাই', 'অগাস্ট', 'সেপ্টেম্বর', 'অক্টোবর', 'নভেম্বর', 'ডিসেম্বর' );

        $str = str_replace( $en, $bn, $str );
        $str = str_replace( $en_short, $bn, $str );

        return $str;
    }

    public function bn_translate_day( $str ) {
        $en = array( 'Saturday', 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday' );
        $en_short = array( 'Sat', 'Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri' );

        $bn = array( 'শনিবার', 'রবিবার', 'সোমবার', 'মঙ্গলবার', 'বুধবার', 'বৃহঃস্পতিবার', 'শুক্রবার' );
        $bn_short = array( 'শনি', 'রবি', 'সোম', 'মঙ্গল', 'বুধ', 'বৃহ', 'শুক্র' );

        $str = str_replace( $en, $bn, $str );
        $str = str_replace( $en_short, $bn_short, $str );

        return $str;
    }
    
    public function bn_translate_am( $str ) {
        $en = array( 'am', 'pm' );
        $bn = array( 'পূর্বাহ্ন', 'অপরাহ্ন' );

        $str = str_replace( $en, $bn, $str );

        return $str;
    }

}

// Register the widget
function iftar_time_2024_widget() {
	register_widget( 'IftarTime2024_Widget' );
}
add_action( 'widgets_init', 'iftar_time_2024_widget' );