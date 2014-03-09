<?php

namespace T3Bits\Podlove\Modules\Contributors;
use Podlove\Model;
use Podlove\Modules\Contributors\Model\Contributor;
use Podlove\Modules\Contributors\Model\EpisodeContribution;

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
			$contributions = EpisodeContribution::all('WHERE `episode_id` = "' . $episode->id . '" ORDER BY `position` ASC');
		} else {
			$contributions = EpisodeContribution::all('GROUP BY contributor_id ORDER BY `position` ASC');
		}
		$list = array();
		foreach ($contributions as $contribution) {
			/** @var EpisodeContribution $contribution */
			/** @var Contributor $contributor */
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

	/**
	 * @param Contributor $contributor
	 * @param string $name
	 * @return string
	 */
	protected function wrapWithLink(Contributor $contributor, $name) {
		return $name;
	}

}


?>