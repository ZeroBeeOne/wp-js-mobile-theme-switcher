<?php
/**
 * Mobile theme switcher admin settings page HTML
 *
 * @author	Sam Pospischil <pospi@spadgos.com>
 * @since	5 Jun 2013
 */

$themes = JSMobileThemeSwitcher::getAvailableThemes();
$options = JSMobileThemeSwitcher::getOptions();

// sort themes for display in list
natcasesort($themes);

?>
<h1>Mobile Themes</h1>

<form method="post" id="jsmts-settings">
	<h3>Select themes</h3>
<p>
	<label for="jsmts_mobile_theme">
		Mobile:
		<select name="mobile_theme" id="jsmts_mobile_theme">
			<option value="">Use primary theme</option>
		<?php foreach ($themes as $dir => $theme) : ?>
			<option value="<?php echo $dir; ?>"<?php selected($dir, $options['mobile_theme']); ?>><?php echo $theme['Name']; ?></option>
		<?php endforeach; ?>
		</select>
	</label>
</p><p>
	<label for="jsmts_tablet_theme">
		Tablet:
		<select name="tablet_theme" id="jsmts_tablet_theme">
			<option value="">Use primary theme</option>
		<?php foreach ($themes as $dir => $theme) : ?>
			<option value="<?php echo $dir; ?>"<?php selected($dir, $options['tablet_theme']); ?>><?php echo $theme['Name']; ?></option>
		<?php endforeach; ?>
		</select>
	</label>
</p><p>

	<h3>State mechanism</h3>
	<blockquote>
		These settings determine the way in which the mobile theme is persisted between page views.<br /><br />
		Using URL parameters has greatest compatibility, but may require additional coding in your theme's URL handling methods to persist values correctly without requiring re-detection. Use this method if you have advanced pre-Wordpress caching mechanisms on your server, for example WPEngine's EverCache.<br />
		To use domain redirection, you must have your DNS configured for the site to be accessible over multiple domain names. To avoid hurting your search engine rankings, mobile themes with similar or identical content should specify <a target="_blank" href="http://support.google.com/webmasters/bin/answer.py?hl=en&answer=139394">&lt;link rel="canonical" /&gt;</a> tags pointing to the desktop theme's URL.<br />
		Cookies have the widest support otherwise, and should work on all standard hosting where requests are consistently handled by Wordpress itself.
	</blockquote>
<p>
	<label for="jsmts_state_method">
		Persist using:
		<select name="state_method" id="jsmts_state_method">
			<option value="qs"<?php selected('qs', $options['state_method']); ?>>URL parameters</option>
			<option value="c"<?php selected('c', $options['state_method']); ?>>Cookies (:TODO:)</option>
			<option value="r"<?php selected('r', $options['state_method']); ?>>Domain redirect</option>
		</select>
	</label>
</p>
<p>
	<label for="jsmts_state_key">
		<span id="skey_name"></span>:
		<input type="text" name="state_key" id="jsmts_state_key" value="<?php echo esc_attr($options['state_key']); ?>" /><br />
		<small>(<span id="skey_hint"></span>)</small>
	</label>
</p>
<p id="secondkey">
	<label for="jsmts_state_key2">
		<span>Tablet theme URL</span>:
		<input type="text" name="state_key2" id="jsmts_state_key2" value="<?php echo esc_attr($options['state_key2']); ?>" /><br />
		<small>(<span>set the domain to redirect to for viewing the tablet theme. This should include the <code>http://</code> or <code>https://</code> prefix but no trailing slashes or paths.)</small>
	</label>
</p>
<p id="canonical">
	<label for="jsmts_do_canonical">
		<input type="checkbox" name="do_canonical" id="jsmts_do_canonical"<?php if ($options['do_canonical']) echo ' checked="checked"'; ?> />
		<span>Output canonical links</span><br />
		<small>(<span>Select to automatically generate canonical link tags on the mobile and tablet theme templates which will redirect search engines to the main desktop site. You should enable this unless your themes already output these themselves or you know what you are doing.</span>)</small>
	</label>
</p>
<p>
	<label for="jsmts_force_protocol">
		Force Protocol:
		<select name="force_protocol" id="jsmts_force_protocol">
			<option value="none"<?php selected('none', $options['force_protocol']); ?>>None (respect browser choice)</option>
			<option value="http"<?php selected('http', $options['force_protocol']); ?>>HTTP</option>
			<option value="https"<?php selected('https', $options['force_protocol']); ?>>HTTPS</option>
		</select>
	</label>
</p>
<p id="rechecking">
	<span>Re-check location:</span><br />
	<label><input type="radio" name="check_type" value="always"<?php if (!$options['do_flag']) echo ' checked="checked"'; ?> /> On every page view</label><br />
	<label><input type="radio" name="check_type" value="closed"<?php if ($options['do_flag'] && !$options['flag_timeout']) echo ' checked="checked"'; ?> /> After the browser is closed</label><br />
	<label><input type="radio" name="check_type" value="timed"<?php if ($options['do_flag'] && $options['flag_timeout']) echo ' checked="checked"'; ?> /> At intervals</label><br />
	<label id="checkinterval">
		<span>Time between checks (min)</span>:
		<input type="text" name="flag_timeout" id="jsmts_flag_timeout"<?php if ($options['flag_timeout']) echo ' value="'.$options['flag_timeout'].'"'; ?> />
	</label>
</p>
<p id="forcechecking">
	<span>Forced Themes (set with the query parameter 'jsmts_force') remain in effect:</span><br />
	<label><input type="radio" name="force_type" value="always"<?php if (!$options['remember_force']) echo ' checked="checked"'; ?> /> For the page they are requested</label><br />
	<label><input type="radio" name="force_type" value="closed"<?php if ($options['remember_force'] && !$options['force_timeout']) echo ' checked="checked"'; ?> /> Until the browser is closed</label><br />
	<label><input type="radio" name="force_type" value="timed"<?php if ($options['remember_force'] && $options['force_timeout']) echo ' checked="checked"'; ?> /> For a set time</label><br />
	<label id="forceinterval">
		<span>Time to remain in effect (min)</span>:
		<input type="text" name="force_timeout" id="jsmts_force_timeout"<?php if ($options['force_timeout']) echo ' value="'.$options['force_timeout'].'"'; ?> />
	</label>
</p>

<p>
	<input type="submit" name="save" value="Update settings" />
</p>
</form>

<style type="text/css">
	#jsmts-settings input[type=text] {
		width: 20em;
	}
	#jsmts-settings blockquote {
		color: #999;
	}
	#rechecking label,
	#forcechecking label {
		margin-left: 2em;
	}
</style>

<script type="text/javascript">
(function($) {
	function isTimeoutChecking($el,timed) {
		if (timed) {
			$el.show();
		} else {
			$el.hide();
		}
	}

	// option hints & labels
	$('#jsmts_state_method').change(function() {
		var lbl = $('#skey_name'),
			hint = $('#skey_hint'),
			secondOpt = $('#secondkey').hide(),
			canonical = $('#canonical').hide();

		switch ($(this).val()) {
			case 'r':
				lbl.html('Mobile theme URL');
				hint.html('set the domain to redirect to for viewing the mobile theme. This should include the <code>http://</code> or <code>https://</code> prefix but no trailing slashes or paths.');
				canonical.show();
				secondOpt.show();
				break;
			case 'c':
				lbl.html('Cookie name');
				hint.html('default can be overridden for advanced use where it would conflict with cookies used by your themes');
				break;
			default:
				lbl.html('Querystring parameter');
				hint.html('default can be overridden for advanced use where it would conflict with URL variables used by your themes');
				break;
		}
	}).change();	// set initial state

	$('#rechecking input[type=radio]').click(function() {
		isTimeoutChecking($('#checkinterval'), $('#rechecking input[type=radio]:checked').val() == 'timed');
	});
	isTimeoutChecking($('#checkinterval'), $('#rechecking input[type=radio]:checked').val() == 'timed');

	$('#forcechecking input[type=radio]').click(function() {
		isTimeoutChecking($('#forceinterval'), $('#forcechecking input[type=radio]:checked').val() == 'timed');
	});
	isTimeoutChecking($('#forceinterval'), $('#forcechecking input[type=radio]:checked').val() == 'timed');
})(jQuery);
</script>
<?php
