jQuery(document).ready(function($) {
	
    wp.customize.bind( 'change', function( setting ) {
        // Trigger a refresh when any setting is changed
        wp.customize.previewer.refresh();
    });
	
    wp.customize('custom_logo', function(value) {
        value.bind(function() {
            wp.customize.preview.send('refresh');
        });
    });
	
    // Append a span to display the value
    $('input[type="range"]').each(function() {
        var $this = $(this);
        var value = $this.val();

        // Create the text input element
        var $textInput = $('<input type="text" class="customizer-range-value" value="' + value + '">');
        $this.after($textInput);

        // Update the text input when the slider is moved
        $this.on('input change', function() {
            $textInput.val($this.val());
        });

        // Update the slider when the text input is changed
        // Update the slider when the text input is changed
        $textInput.on('input change', function() {
            var newValue = parseFloat($textInput.val());
            if (!isNaN(newValue)) {
                newValue = Math.max(Math.min(newValue, parseFloat($this.attr('max'))), parseFloat($this.attr('min')));
                $this.val(newValue).trigger('input');
            }
        });
    });
	
	function loadCustomScript(filePath) {
		$.getScript(filePath, function() {
		});
	}

	// Check if the desired section is expanded when the Customizer loads
	wp.customize.section('monawp_global_panel_colors', function(section) {
		
		// Define a flag on the section object to track if the script is loaded
		section.scriptLoaded = false;

		function loadColorPalettesScript() {
			if (!section.scriptLoaded) {
				loadCustomScript(monawp_customizer_vars.templateDirectoryUri + '/js/color_palettes.js');
				section.scriptLoaded = true;
			}
		}

		// Check if the section is already expanded when the script runs
		if (section.expanded()) {
			loadColorPalettesScript();
		}

		// Bind to the expanded state changes
		section.expanded.bind(function(isExpanded) {
			if (isExpanded) {
				loadColorPalettesScript();
			}
		});
	});

	wp.customize.section('monawp_presets_panel_global', function(section) {

		// Define a flag on the section object to track if the script is loaded
		section.scriptLoaded = false;

		function loadCustomizerOptionPresetsScript() {
			if (!section.scriptLoaded) {
				loadCustomScript(monawp_customizer_vars.templateDirectoryUri + '/js/customizer_option_presets.js');
				section.scriptLoaded = true;
			}
		}

		// Check if the section is already expanded when the script runs
		if (section.expanded()) {
			loadCustomizerOptionPresetsScript();
		}

		// Bind to the expanded state changes
		section.expanded.bind(function(isExpanded) {
			if (isExpanded) {
				loadCustomizerOptionPresetsScript();
			}
		});
	});

	wp.customize.section('monawp_presets_panel_header', function(section) {
		console.log('Watching section:', section.id);

		// Define a flag on the section object to track if the script is loaded
		section.scriptLoaded = false;

		function loadCustomizerOptionPresetsScript() {
			if (!section.scriptLoaded) {
				loadCustomScript(monawp_customizer_vars.templateDirectoryUri + '/js/customizer_header_builds.js');
				section.scriptLoaded = true;
			}
		}

		// Check if the section is already expanded when the script runs
		if (section.expanded()) {
			loadCustomizerOptionPresetsScript();
		}

		// Bind to the expanded state changes
		section.expanded.bind(function(isExpanded) {
			console.log('Section expanded state changed:', isExpanded);
			if (isExpanded) {
				loadCustomizerOptionPresetsScript();
			}
		});
	});
});

