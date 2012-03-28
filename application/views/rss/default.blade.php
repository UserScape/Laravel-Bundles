<?php echo '<?xml version="1.0" encoding="utf-8"?>'."\n"; ?>
<rss version="2.0"
	xmlns:atom="http://www.w3.org/2005/Atom"
	xmlns:dc="http://purl.org/dc/elements/1.1/"
	xmlns:sy="http://purl.org/rss/1.0/modules/syndication/"
	xmlns:admin="http://webns.net/mvcb/"
	xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
	xmlns:content="http://purl.org/rss/1.0/modules/content/">

	<channel>
		<title>Laravel Bundles</title>
		<link>{{URL::to()}}</link>
		<description>Bundles for your Laravel Application</description>
		<dc:language>en</dc:language>
		<dc:rights>Copyright <?php echo date("Y"); ?></dc:rights>
		<dc:date><?php echo gmdate("Y-m-d\TH:i:s\Z", time()); ?></dc:date>
		<admin:generatorAgent rdf:resource="http://bundles.laravel.com/" />
		<atom:link href="{{URL::current()}}" rel="self" type="application/rss+xml" />

			@if (count($bundles) > 0)
				@foreach ($bundles as $bundle)
					<item>
						<title>{{$bundle->title}}</title>
						<link>{{URL::to('bundle/detail/'.$bundle->uri)}}</link>
						<guid>{{URL::to('bundle/detail/'.$bundle->uri)}}</guid>
						<description>{{$bundle->summary}}</description>
						<description><?php echo '<![CDATA['; ?>{{$bundle->summary}}]]></description>
						<dc:date>{{gmdate("Y-m-d\TH:i:s\Z", strtotime($bundle->created_at))}}</dc:date>
					</item>
				@endforeach
			@else
				<item>
					<title>No Bundles</title>
					<link><?php echo URL::to(); ?></link>
					<guid><?php echo URL::to(); ?></guid>
					<dc:date><?php echo gmdate("Y-m-d\TH:i:s\Z", time()); ?></dc:date>
				</item>
			@endif
	</channel>
</rss>