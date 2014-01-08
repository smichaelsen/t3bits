<?php

namespace T3Bits\Podlove\Modules\Contributors;
use \Podlove\Model;

class Shortcodes extends \Podlove\Modules\Contributors\Shortcodes {

	public function __construct() {
		remove_shortcode('podlove-contributors');
		remove_shortcode('podlove-contributor-list');
		add_shortcode('podlove-contributor-list', array( $this, 'podlove_contributor_list') );
	}

	/**
	 * @return string
	 */
	public function podlove_contributor_list($attributes) {

		// fetch contributions
		if ($episode = Model\Episode::get_current()) {
			$contributions = \Podlove\Modules\Contributors\Model\EpisodeContribution::all('WHERE `episode_id` = "' . $episode->id . '" ORDER BY `position` ASC');
		} else {
			$contributions = \Podlove\Modules\Contributors\Model\EpisodeContribution::all('GROUP BY contributor_id ORDER BY `position` ASC');
		}
		$list = array();
		foreach ($contributions as $contribution) {
			/** @var \Podlove\Modules\Contributors\Model\EpisodeContribution $contribution */
			/** @var \Podlove\Modules\Contributors\Model\Contributor $contributor */
			$contributor = $contribution->getContributor();
			$list[] = '<span>'
				. '<span class="avatar">' . $contributor->getAvatar(18) . '</span>'
				. ' <span class="name">' . $this->wrapWithLink($contributor, $contributor->getName()) . '</span>'
				. '</span>';
		}

		$html = '<span class="podlove-contributors">';
		$html.= implode(", ", $list);
		$html.= '</span>';

		return $html;
	}

	protected function wrapWithLink($contributor, $name) {
		return $name;
	}

}


?>