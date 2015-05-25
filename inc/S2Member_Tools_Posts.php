<?php
/**
 * Created by PhpStorm.
 * User: staude
 * Date: 12.05.15
 * Time: 15:49
 */

class S2Member_Tools_Posts {
	/**
	 *
	 * @since   0.1
	 * @param   $defaults
	 * @return  mixed
	 */
	static public function add_post_list_columns_head ( $defaults ) {
		$defaults[ 's2m_memberlevel' ] = _x( 'S2M Memberlevel', 'Pagelist columns header', S2Member_Tools::get_textdomain() );
		$defaults[ 's2m_customcap' ] = _x( 'S2M Custom capability', 'Pagelist columns header', S2Member_Tools::get_textdomain() );

		return $defaults;
	}

	/**
	 *
	 * @since   0.1
	 * @param   $column_name
	 * @param   $page_id
	 * @return  void
	 */
	static public function add_post_list_columns_data( $column_name, $page_id ) {

		if ( 's2m_memberlevel' == $column_name ) {
			$level = 0;
			$s2moptions = S2Member_Tools::get_s2m_options();
			while (true) {
				if ( $s2moptions[ 'level' . $level . '_posts' ]  ) {
					if ( in_array( $page_id, explode(',', $s2moptions[ 'level' . $level . '_posts' ] ) ) ) {
						if ( $s2moptions[ 'level' . $level . '_label' ]  ) {
							echo $s2moptions[ 'level' . $level . '_label' ];
						}
					}
				} else {
					break;
				}
				$level++;
			}
		}
		if ( 's2m_customcap' == $column_name ) {
			$data = get_post_meta( $page_id, 's2member_ccaps_req', true );
			if ( is_array( $data ) ) {
				asort( $data );
				foreach ( $data as $capability ) {
					echo $capability . '<br/>';
				}
			}
		}

	}
}