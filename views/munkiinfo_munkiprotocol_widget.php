<div class="col-lg-4 col-md-6">
	<div class="card" id="munkiinfo-munkiprotocol-widget">
	  <div class="card-header" data-container="body" data-i18n="[title]munkiinfo.munkiprotocol.tooltip">
	    <i class="fa fa-magic"></i>
        <span data-i18n="munkiinfo.munkiprotocol.title"></span>
        <a href="/show/listing/munkireport/munki" class="pull-right"><i class="fa fa-list"></i></a>
	  </div>
	  <div class="card-body text-center">
        <a tag="http" class="btn btn-danger disabled">
            <span class="bigger-150"> 0 </span><br>
            <span data-i18n="munkiinfo.munkiprotocol.http"></span>
        </a>
        <a tag="https" class="btn btn-success disabled">
            <span class="bigger-150"> 0 </span><br>
            <span data-i18n="munkiinfo.munkiprotocol.https"></span>
        </a>
        <a tag="localrepo" class="btn btn-info disabled">
            <span class="bigger-150"> 0 </span><br>
            <span data-i18n="munkiinfo.munkiprotocol.localrepo"></span>
        </a>
	  </div>
	</div><!-- /card -->
</div><!-- /col -->

<script>
$(document).on('appReady', function(){

	var panelBody = $('#munkiinfo-munkiprotocol-widget div.card-body');

	// Tags
	var tags = ['http', 'https', 'localrepo'];

	// Set url
	$.each(tags, function(i, tag){
		$('#munkiinfo-munkiprotocol-widget a[tag="'+tag+'"]')
			.attr('href', appUrl + '/show/listing/munkiinfo/munkiinfo/#munkiprotocol');
	});

	$(document).on('appUpdate', function(){

		$.getJSON( appUrl + '/module/munkiinfo/get_protocol_stats', function( data ) {

			$.each(tags, function(i, tag){
				// Set count
				$('#munkiinfo-munkiprotocol-widget a[tag="'+tag+'"]')
					.toggleClass('disabled', ! data[tag])
					.find('span.bigger-150')
						.text(+data[tag]);
				// Set localized label
				$('#munkiinfo-munkiprotocol-widget a[tag="'+tag+'"] span.count')
					.text(i18n.t(tag, { count: +data[tag] }));
			});

		});

	});

});

</script>
