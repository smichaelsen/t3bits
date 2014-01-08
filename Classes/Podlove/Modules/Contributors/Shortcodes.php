<?php

namespace T3Bits\Podlove\Modules\Contributors;
use \Podlove\Model;

class Shortcodes extends \Podlove\Modules\Contributors\Shortcodes {

	/**
	 * List of contributions to be rendered.
	 */
	private $contributions = array();

	private $id;

	/**
	 * Shortcode settings.
	 */
	private $settings = array();

	public function __construct() {
		remove_shortcode('podlove-contributors');
		remove_shortcode('podlove-contributor-list');
		add_shortcode('podlove-contributor-list', array( $this, 'podlove_contributor_list') );
	}

	/**
	 * Parameters:
	 *
	 *	preset      - One of 'table', 'list', 'comma separated'. Default: 'table'
	 *	title       - Optional table header title. Default: none
	 *	avatars     - One of 'yes', 'no'. Display avatars. Default: 'yes'
	 *	role        - Filter lists by role. Default: 'all'
	 *	roles       - One of 'yes', 'no'. Display role. Default: 'no'
	 *	group       - Filter lists by group. Default: 'all'
	 *	groups      - One of 'yes', 'no'. Display group. Default: 'no'
	 *	donations   - One of 'yes', 'no'. Display donation column. Default: 'no'
	 *	flattr      - One of 'yes', 'no'. Display Flattr column. Default: 'yes'
	 *	linkto      - One of 'none', 'publicemail', 'www', 'adn', 'twitter', 'facebook', 'amazonwishlist'.
	 *	              Links contributor name to the service if available. Default: 'none'
	 *
	 * Examples:
	 *
	 *	[podlove-contributor-list]
	 *
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
				. (($this->settings['avatars'] == 'yes') ? '<span class="avatar">' . $contributor->getAvatar(18) . '</span>' : '')
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