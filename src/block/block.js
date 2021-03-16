const { __ } = wp.i18n; // Import __() from wp.i18n
import { SelectControl } from 'wordpress user/components';
import { withState } from 'wordpress user/compose';
const {
	registerBlockType,
	AlignmentToolbar,
	BlockControls,
	InspectorControls,
} = wp.blocks;
const { withSelect } = wp.data;
const blockStyle = {
	backgroundColor: '#900',
	color: '#fff',
	padding: '20px',
};
const MySelectControl = withState( {
	size: '50%',
} )( ( { size, setState } ) => (
	<SelectControl
		label="Size"
		value={ size }
		options={ [
			{ label: 'Big', value: '100%' },
			{ label: 'Medium', value: '50%' },
			{ label: 'Small', value: '25%' },
		] }
		onChange={ ( size ) => {
			setState( { size } );
		} }
	/>
) );
registerBlockType( 'mansi-caterers/slider', {
	title: 'Slider',
	icon: 'megaphone',
	category: 'mansi-caterers',

	edit: withSelect( ( select ) => {
		return {
			posts: select( 'core' ).getEntityRecords( 'postType', 'slider' ),
		};
	} )( ( { posts, className } ) => {
		if ( ! posts ) {
			return 'Loading...';
		}

		if ( posts && posts.length === 0 ) {
			return 'No posts';
		}
		const post = posts[ 0 ];

		// return <a style={blockStyle} className={ className } href={ post.link }>
		//  { post.title.rendered }
		// </a>;
		return <div style={ blockStyle } className={ className }>Slider Set</div>;
	} ),

	save() {
		// Rendering in PHP
		return null;
	},
} );
