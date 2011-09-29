<?php
class Getid3Component extends Object {

	var $controller;
	var $result = array();

	function initialize()	{

            set_time_limit(20*3600);
            ignore_user_abort(false);
            App::import('Vendor', 'getid3');
	}

	function info($filepath)	{

            $getid3 = new getID3;
            $getid3->encoding = 'UTF-8';

            // Tell browser to use UTF-8 encoding as well.
            header('Content-Type: text/html; charset=UTF-8');
            try {

                    $getid3->Analyze($filepath);
                    return $getid3->info;

            }
            catch (Exception $e) {
                    return 'An error occured: ' .  $e->message;
            }
	}	

	function extract($full_name)	{

            $getid3 = new getID3;
            $getid3->encoding = 'UTF-8';

            if (!is_file($full_name)) {
                    return "ERROR: file ($full_name) does not exists";
            }

            //$g = new xml_gen;

            try {

                    $time = getmicrotime();

                    $getid3->Analyze($full_name);//die;
                    $time = getmicrotime() - $time;

                    $this->result['filename'] = basename($getid3->filename);
                    $this->result['filesize'] = @$getid3->info['filesize'];
                    $this->result['fileformat'] = @$getid3->info['fileformat'];
                    $this->result['duration'] = @$getid3->info['playtime_seconds'];

					if( isSet( $getid3->info['audio'] ) ) 
						$this->result['audio'] = $getid3->info['audio'];
					if( isSet( $getid3->info['video'] ) ) 
						$this->result['video'] = $getid3->info['video'];
					
                    if (@$getid3->info['audio']['dataformat'] && $getid3->info['audio']['dataformat'] != $getid3->info['fileformat']) {
						$this->result['audio']['dataformat'] = @$getid3->info['fileformat'];
                    }

                    if (@$getid3->info['video']['dataformat'] && $getid3->info['video']['dataformat'] != $getid3->info['fileformat'] && $getid3->info['video']['dataformat'] != @$getid3->info['audio']['dataformat']) {
                            $this->result['video']['dataformat'] = @$getid3->info['fileformat'];
                    }

                    $this->result['length'] = @$getid3->info['playtime_string'];

                    $this->result['bitrate'] = (@$getid3->info['bitrate'] ? number_format($getid3->info['bitrate']/1000) . 'k' : '');

                    $this->result['audio']['sample_rate'] = @$getid3->info['audio']['sample_rate'] ? number_format($getid3->info['audio']['sample_rate']) . '/' .  (@$getid3->info['audio']['bits_per_sample'] ? $getid3->info['audio']['bits_per_sample'] . '/' : '') .  @$getid3->info['audio']['channels'] : '';

                    $this->result['artist'] = $this->result['title'] = $this->result['album'] = '';

                    if (@$getid3->info['tags']) {
                            foreach ($getid3->info['tags'] as $tag => $tag_info) {
                                    if (@$getid3->info['tags'][$tag]['artist'] || @$getid3->info['tags'][$tag]['title'] || @$getid3->info['tags'][$tag]['album'] || @$getid3->info['tags'][$tag]['genre']) {
                                            $this->result['artist'] = @implode('', @$getid3->info['tags'][$tag]['artist']);
                                            $this->result['title']  = @implode('', @$getid3->info['tags'][$tag]['title']);
                                            $this->result['album']  = @implode('', @$getid3->info['tags'][$tag]['album']);
                                            $this->result['genre']  = @implode('', @$getid3->info['tags'][$tag]['genre']);
                                            break;
                                    }
                            }
                    }

                    $this->result['tags'] = @implode(", ", @array_keys(@$getid3->info['tags']));

                    $this->result['warning'] = @implode("", @$getid3->info['warning']);

                    return $this->result;
            }

			catch (Exception $e) {
            	return 'ERROR: ' . $e->message;
            }
	}
}