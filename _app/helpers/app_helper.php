<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists( 'checkEmail' ) ) {
	function checkEmail( $email ) {
	   if ( strpos( $email, '@' ) !== false ) {
	      $split = explode( '@', $email );
	      return ( strpos( $split['1'], '.' ) !== false ? true : false);
	   } else {
	      return false;
	   }
	}
}

if ( ! function_exists( 'randStrGen' ) ){
	function randStrGen( $len ){
	    $result = "";
	    $chars = "abcdefghijklmnopqrstuvwxyz0123456789$11";
	    $charArray = str_split( $chars );
	    for( $i = 0; $i < $len; $i++ ){
		    $randItem = array_rand( $charArray );
		    $result .= "".$charArray[$randItem];
	    }
	    return $result;
	}
}


if ( ! function_exists( 'getrolename' ) ) {
	function getrolename( $id ) {
		$ci =& get_instance();
		$rs = (object) $ci->db
		->select('role.name as rolename,user.iduser')
		->join('roleuser','user.iduser = roleuser.iduser','left')
		->join('role','role.idrole = roleuser.idrole','left')
		->where('user.iduser',$id)->get('user')->row_array();
		return ($rs->rolename <> null)? ucwords(strtolower($rs->rolename)) : 'N/A';
	}
}

/* tool */
if (!function_exists('disp')){
	function disp( $data, $title = '' ){
	    echo '<pre>';
	    if ( ! empty( $title ) ) {
	    	echo "<h3>$title</h3>";
	    }
	    print_r( $data );
	    echo '</pre>';
	}
}

/* general */

if ( ! function_exists( 'enc' ) ) {
	function enc($data) {
		$data_on = base64_encode(serialize($data));
		return preg_replace('/\=+/', '-', $data_on);
	}
}

if ( ! function_exists( 'dec' ) ) {
	function dec($data) {
		$on_data = preg_replace('/\-+/', '=', $data);
		return unserialize(base64_decode($on_data));
	}
}

if ( ! function_exists( 'filter_json' ) ) {
	function filter_json( $json ){
		$arr_where = [];
		$arr_filter = json_decode( $json, true );
		foreach ( $arr_filter as $value ) {
			if ( in_array( 'op', $value ) ) {
				if ( $value['op'] == 'contains' ) {
					$arr_where['like'] = [ $value['field'] => $value['value'] ];
				}
			} else {
				$arr_where['like'] = [ $value['filter_field'] => $value['filter_value'] ];
			}
		}
		return $arr_where;
	}
}

if ( ! function_exists( 'client_ip' ) ) {
	function client_ip(){
		$is_proxy = false;
		if ( ! empty( $_SERVER['HTTP_CLIENT_IP'] ) ) {
			$ip_address = $_SERVER['HTTP_CLIENT_IP'];
		} elseif ( ! empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
			//whether ip is from proxy
			$ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
			$is_proxy = true;
		} else {
			//whether ip is from remote address
			$ip_address = $_SERVER['REMOTE_ADDR'];
		}
		return [
			'ip_address' => $ip_address,
			'is_proxy' => $is_proxy,
		];
	}
}
