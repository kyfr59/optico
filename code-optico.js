<script type="text/javascript">
    var opticoCountryCode = 33;
    var opticoPhoneColor = '#931e71'; // optional: #3e3e3e
    var opticoClickColor = ''; // optional: #ff5500
    var opticoOptions = { // optional
        // checks to activate tracking or not
        // checks query parameters and its values (can use wildcard "*")
        trackingRestrictionParameters: {},
        // operator between the parameters check
        trackingRestrictionOperator: 'OR',

        // track only this kind of original phone numbers
        phoneMatching: {
            pattern: __PATTERN__,
            ignoreDefaultPattern: true,
            length: null,
            minLength: null,
            maxLength: null
        },

        // for multiple number types: array of prefixes to number types
        // (use id's from tracking api doc) e.g.: {'01': 6, '02': 7, 'default': 6}
        trackingTypeAssociation: {},

        // make direct call on mobile when clicking on the tracking number
        clickMobileDirectCall: false
    };

    var opticoDirectDisplay = false;

    var opticoScript = document.createElement('script');
    opticoScript.type = 'text/javascript';
    opticoScript.async = false;
    opticoScript.src = '//optico.fr/client.js';
    var opticoS = document.getElementsByTagName('script')[0];
    opticoS.parentNode.insertBefore(opticoScript, opticoS);
    console.log('Le code Optico est chargé.');
</script>