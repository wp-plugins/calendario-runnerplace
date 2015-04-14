<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

class RPRC_widget extends WP_Widget {
 
    function RPRC_widget(){
        // Constructor del Widget.
        $widget_ops = array('classname' => 'RPRC_widget', 'description' => "Calendario de carreras populares RunnerPlace" );
        $this->WP_Widget('RPRC_widget', "Calendario de Carreras populares", $widget_ops);
    }
    
    function widget($args,$instance){
        
        extract( $args );
        isset($_GET['task']) ? parseInput($_GET['task']) : null;
        // these are the widget options
        $title = apply_filters('widget_title', $instance['title']);
        $sport_type = (!empty($instance['sport_type']) ? $instance['sport_type'] : "sport_type");
        $region = (!empty($instance['region']) ? $instance['region'] : "region");
        $poweredbyLink = (!empty($instance['poweredbyLink']) ? $instance['poweredbyLink'] : "");
        $RPlinks = (!empty($instance['RPlinks']) ? $instance['RPlinks'] : "");
                
        $regions_array = array(
            '621' => 'A Coru&ntilde;a',
            '620' => '&Aacute;lava',
            '643' => 'Albacete',
            '641' => 'Alicante',
            '623' => 'Almer&iacute;a',
            '659' => 'Asturias',
            '628' => '&Aacute;vila',
            '649' => 'Badajoz',
            '648' => 'Barcelona',
            '657' => 'Burgos',
            '626' => 'C&aacute;ceres',
            '613' => 'C&aacute;diz',
            '622' => 'Cantabria',
            '630' => 'Castell&oacute;n',
            '634' => 'Ceuta',
            '618' => 'Ciudad Real',
            '642' => 'C&oacute;rdoba',
            '644' => 'Cuenca',
            '639' => 'Girona',
            '640' => 'Granada',
            '627' => 'Guadalajara',
            '617' => 'Guip&uacute;zcoa',
            '653' => 'Huelva',
            '658' => 'Huesca',
            '656' => 'Baleares',
            '638' => 'Ja&eacute;n',
            '633' => 'La Rioja',
            '609' => 'Las Palmas',
            '655' => 'Le&oacute;n',
            '654' => 'Lleida',
            '632' => 'Lugo',
            '650' => 'Madrid',
            '660' => 'M&aacute;laga',
            '647' => 'Melilla',
            '635' => 'Murcia',
            '614' => 'Navarra',
            '615' => 'Ourense',
            '611' => 'Palencia',
            '645' => 'Pontevedra',
            '636' => 'Salamanca',
            '625' => 'Santa Cruz de Tenerife',
            '616' => 'Segovia',
            '651' => 'Sevilla',
            '610' => 'Soria',
            '631' => 'Tarragona',
            '646' => 'Teruel',
            '629' => 'Toledo',
            '652' => 'Valencia',
            '637' => 'Valladolid',
            '619' => 'Vizcaya',
            '612' => 'Zamora',
            '624' => 'Zaragoza'
            );
        
        $sport_types_array = array(
            'running' => 'Running',
            'duatlon' => 'Duatlón',
            'duatlon-cross' => 'Duatlón Cross',
            'triatlon' => 'Triatlón',
            'triatlon-cross' => 'Triatlón Cross',
            'trail' => 'Trail',
            'acuatlon' => 'Acuatlón'
            );         
        
        // Contenido del Widget que se mostrará en la Sidebar
        echo $before_widget;    
        ?>

        <style>

            #form_calendar
            {
                width: 100%;
                min-height: 150px;
                display: block;
                -webkit-box-sizing: border-box; /* Safari/Chrome, other WebKit */
                 -moz-box-sizing: border-box;    /* Firefox, other Gecko */
                      box-sizing: border-box;         /* Opera/IE 8+ */
            }

            .contained-list {
              overflow-y: auto;
              overflow-x: hidden;
              max-height: 22.85em;
              width: 100%;
            }

            .contained-list li {
              padding: 2% 0;
              padding-left: 30px;
              }

            .contained-list li a {
              cursor: pointer;
              font-weight: 600; 
            }

            select {
                width: 95%;
                text-indent: 0.01px;
                text-overflow: "";
                height: 30px;
                margin-bottom: 2px;
                vertical-align: middle;
                font-size: 1em;
                font-weight: 500;
                padding: 0.4em;
            }

        </style>

<aside id='RPRC_widget' class='widget RPRC_widget'>
    <div id="form_calendar">
            <h3 class='widget-title'><?=$title?></h3>
            <form action="" class="" id="calendar_widget" name="calendar_widget" method="post">
                <div class="form__element clearfix">
                    <select name="race_type" id="race_type" class="input-medium selectpicker" data-width="180px">
                        <option value="" selected>Todos los deportes</option>
                        <?php foreach( $sport_types_array as $var => $sport_type_array ): ?>
                            <option value="<?php echo $var ?>"<?php if( $var == $sport_type ): ?> selected="selected"<?php endif; ?>><?php echo $sport_type_array ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form__element clearfix">
                    <select name="month" id="month" class="input-medium selectpicker" data-width="180px">
                        <option value="" selected>Selecciona mes</option>
                        <option value="1">Enero</option>
                        <option value="2">Febrero</option>
                        <option value="3">Marzo</option>
                        <option value="4">Abril</option>
                        <option value="5">Mayo</option>
                        <option value="6">Junio</option>
                        <option value="7">Julio</option>
                        <option value="8">Agosto</option>
                        <option value="9">Septiembre</option>
                        <option value="10">Octubre</option>
                        <option value="11">Noviembre</option>
                        <option value="12">Diciembre</option>
                    </select>
                </div>
                <div class="form__element clearfix">
                    <select name="region" id="region" class="input-medium selectpicker" data-width="180px">
                    <option value="" selected>Selecciona una provincia</option>
                    <?php foreach( $regions_array as $var => $region_array ): ?>
                        <option value="<?php echo $var ?>"<?php if( $var == $region ): ?> selected="selected"<?php endif; ?>><?php echo $region_array ?></option>
                    <?php endforeach; ?>
                </select>
                </div>
            </form>
            <div><button class="button" id="search_button">Buscar</button>
            </div>
    </div>
            <!-- ***** LISTA CARRERAS ***** -->
            <div id="racesList" class="races_list">
            <?php 
            $RPserver="http://www.runnerplace.com/";
            $url = $RPserver."api/list_races/$region/month/$sport_type";
            
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_HEADER, false);
            $races = curl_exec($curl);
            curl_close($curl);
   
            $races = json_decode($races,true); 
            
            
            ?>
            <ul id="contained-list" class="contained-list">
                <?php
                if ($RPlinks=="RPlinks") {
                    for($i=0;$i<count($races);$i++){ 
                        echo "
                            <li class='race'>
                            <a rel='nofollow' href='".$RPserver.$races[$i]['RPuri']."' target=\"_blank\">
                                <div><span class='title' title='".$races[$i]['title']."'>".$races[$i]['title']."</span><br/>
                            </a>
                            <span class='small date'>". $races[$i]['read_start_date'] ."</span>
                            <span class='small date'> - ". $races[$i]['address'] ."</span>
                          </div>
                        </li>";
                    }                    
                } else {
                    for($i=0;$i<count($races);$i++){ 
                    echo "
                        <li class='race'>
                        <div><span class='title' title='".$races[$i]['title']."'>".$races[$i]['title']."</span><br/>
                        <span class='small date'>". $races[$i]['read_start_date'] ."</span>
                        <span class='small date'> - ". $races[$i]['address'] ."</span>
                      </div>
                    </li>";
                    }
                }

                ?>
            </ul> <!-- .contained-list -->
            </div>
            <?php if ($poweredbyLink=="poweredbyLink") { ?>
                <div id="poweredby">Powered by <a href="http://www.runnerplace.com">RunnerPlace</a></div>
            <?php } ?>
        </aside>
    <script src="http://code.jquery.com/jquery-1.11.0.js"></script>

    <script type="text/javascript">
    //From "BUSCAR button.
    $(document).ready(function()
    {
        $('body').on('click','#search_button', function()
        {
                if ($("#race_type").val()) {
                    var race_type=$("#race_type").val();
                }else {
                    var race_type="race_type";
                }
                if ($("#region").val()) {
                    var region=$("#region").val();
                }else {
                    var region="region";
                }
                if ($("#month").val()) {
                    var month=$("#month").val();
                }else {
                    var month="month";
                }
                
                var form = "blog";
                var races = [];
                var URL="<?=$RPserver?>api/list_races";

                $.ajax({
                    url: URL+"/"+region+"/"+month+"/"+race_type,
                    type: 'GET',
                    cache: false,
                    dataType: 'jsonp',
                    success: function(data)  {
                        var options = '';
                        $.each(data, function(x, val) {
                            options += '<li class="race">\
                            <a rel="nofollow" href="<?=$RPserver?>'+ val['RPuri'] +'" target="_blank"><div>\
                            <span class="title" title="'+val['title']+'">'+val['title']+'</span><br/></a>\
                            <span class="small date">'+ val['read_start_date'] +'</span>\
                            <span class="small date"> - '+ val['address'] +'</span>\
                            </div></li>';

                            races[x] = [];
                            $.each(val, function(key, value) {
                                races[x][key] = value;
                            });
                        });
                    
                        $("#contained-list").html(options);
                    },
                    error: function(e) {
                        alert('Error: '+e);
                    }
                    
                });

            });

        });

    </script>        <?php
        echo $after_widget;
    }
 
    function update($new_instance, $old_instance){
        $instance = $old_instance;
        // Fields
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['sport_type'] = strip_tags($new_instance['sport_type']);
        $instance['region'] = strip_tags($new_instance['region']);
        $instance['poweredbyLink'] = strip_tags($new_instance['poweredbyLink']);
        $instance['RPlinks'] = strip_tags($new_instance['RPlinks']);
        
        return $instance;
    }
 
// Widget Backend. form creation

    function form($instance) {
        // Check values
        if( $instance) {
            $title = esc_attr($instance['title']);
            $sport_type = $instance['sport_type'];
            $region= $instance['region'];
            $poweredbyLink = $instance['poweredbyLink'];
            $RPlinks = $instance['RPlinks'];
        } else {
            $title = '';
            $sport_type = '';
            $region = '';
            $poweredbyLink = '';
            $RPlinks = '';
        }
        
        
        $regions_array = array(
            '621' => 'A Coru&ntilde;a',
            '620' => '&Aacute;lava',
            '643' => 'Albacete',
            '641' => 'Alicante',
            '623' => 'Almer&iacute;a',
            '659' => 'Asturias',
            '628' => '&Aacute;vila',
            '649' => 'Badajoz',
            '648' => 'Barcelona',
            '657' => 'Burgos',
            '626' => 'C&aacute;ceres',
            '613' => 'C&aacute;diz',
            '622' => 'Cantabria',
            '630' => 'Castell&oacute;n',
            '634' => 'Ceuta',
            '618' => 'Ciudad Real',
            '642' => 'C&oacute;rdoba',
            '644' => 'Cuenca',
            '639' => 'Girona',
            '640' => 'Granada',
            '627' => 'Guadalajara',
            '617' => 'Guip&uacute;zcoa',
            '653' => 'Huelva',
            '658' => 'Huesca',
            '656' => 'Baleares',
            '638' => 'Ja&eacute;n',
            '633' => 'La Rioja',
            '609' => 'Las Palmas',
            '655' => 'Le&oacute;n',
            '654' => 'Lleida',
            '632' => 'Lugo',
            '650' => 'Madrid',
            '660' => 'M&aacute;laga',
            '647' => 'Melilla',
            '635' => 'Murcia',
            '614' => 'Navarra',
            '615' => 'Ourense',
            '611' => 'Palencia',
            '645' => 'Pontevedra',
            '636' => 'Salamanca',
            '625' => 'Santa Cruz de Tenerife',
            '616' => 'Segovia',
            '651' => 'Sevilla',
            '610' => 'Soria',
            '631' => 'Tarragona',
            '646' => 'Teruel',
            '629' => 'Toledo',
            '652' => 'Valencia',
            '637' => 'Valladolid',
            '619' => 'Vizcaya',
            '612' => 'Zamora',
            '624' => 'Zaragoza'
            );
        
        $sport_types_array = array(
            'running' => 'Running',
            'duatlon' => 'Duatlón',
            'duatlon-cross' => 'Duatlón Cross',
            'triatlon' => 'Triatlón',
            'triatlon-cross' => 'Triatlón Cross',
            'trail' => 'Trail',
            'acuatlon' => 'Acuatlón'
            );   
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Título', 'wp_widget_plugin'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('sport_type'); ?>"><?php _e('Deporte:', 'wp_widget_plugin'); ?></label>
            <select name="<?php echo $this->get_field_name('sport_type'); ?>" id="<?php echo $this->get_field_id('sport_type'); ?>" class="input-medium selectpicker" data-width="180px">
                <option value="" selected>Todos los tipos</option>
                <?php foreach( $sport_types_array as $var => $sport_type_array ): ?>
                    <option value="<?php echo $var ?>"<?php if( $var == $sport_type ): ?> selected="selected"<?php endif; ?>><?php echo $sport_type_array ?></option>
                <?php endforeach; ?>
            </select>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('region'); ?>"><?php _e('Provincia:', 'wp_widget_plugin'); ?></label>
            <select name="<?php echo $this->get_field_name('region'); ?>" id="<?php echo $this->get_field_id('region'); ?>" class="input-medium selectpicker" data-width="180px">
                <option value="" selected>Todas las provincias</option>
                <?php foreach( $regions_array as $var => $region_array ): ?>
                    <option value="<?php echo $var ?>"<?php if( $var == $region ): ?> selected="selected"<?php endif; ?>><?php echo $region_array ?></option>
                <?php endforeach; ?>
            </select>
        </p>
        <p>
            <input type="checkbox" <?php if ($RPlinks=="RPlinks") { echo "checked"; }?> class="widefat" id="<?php echo $this->get_field_id('RPlinks'); ?>" name="<?php echo $this->get_field_name('RPlinks'); ?>" type="text" value="RPlinks" />
            <label for="<?php echo $this->get_field_id('RPlinks'); ?>"><?php _e('Enlazar las carreras a las fichas de RunnerPlace', 'wp_widget_plugin'); ?></label>
        </p>
        <p>
            <input type="checkbox" <?php if ($poweredbyLink=="poweredbyLink") { echo "checked"; }?>  class="widefat" id="<?php echo $this->get_field_id('poweredbyLink'); ?>" name="<?php echo $this->get_field_name('poweredbyLink'); ?>" type="text" value="poweredbyLink" />
            <label for="<?php echo $this->get_field_id('poweredbyLink'); ?>"><?php _e('Powered by RunnerPlace link. Si quieres ayudarnos a mejorar añade este enlace.', 'wp_widget_plugin'); ?></label>
        </p>
        <?php
    } 
} 

