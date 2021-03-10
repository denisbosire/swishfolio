/**
 * BLOCK: swishfolio-lite
 *
 * Registering a basic block with Gutenberg.
 * Simple block, renders and saves the same content without any interactivity.
 */

//  Import CSS.
import './editor.scss';
import './style.scss';
import edit from './edit';

const { __ } = wp.i18n; // Import __() from wp.i18n
const { registerBlockType } = wp.blocks; // Import registerBlockType() from wp.blocks

registerBlockType( 'swishfolio/portfolio-masonry', {
	// Block name. Block names must be string that contains a namespace prefix. Example: my-plugin/my-custom-block.
	title: __( 'Portfolio - Masonry' ), // Block title.
	icon: 'shield', // Block icon from Dashicons → https://developer.wordpress.org/resource/dashicons/.
	category: 'common', // Block category — Group blocks together based on common traits E.g. common, formatting, layout widgets, embed.
	keywords: [
		__( 'Portfolio' ),
		__( 'Masonry' ),
		__( 'Swishfolio' ),
	],
	supports: {
		align: [ 'wide', 'full' ],
		html: false,
	},
	attributes: {
		overlay: {
			type: 'string',
			source: 'attribute',
			selector: 'div',
			attribute: 'class',
		},
		columns: {
			type: 'string',
			default: 'col-md-3',
		},
		category: {
			type: 'boolean',
		},
		gutter: {
			type: 'string',
		},
		borderRadius: {
			type: 'string',
		},
	},
	edit,
	save: ( props ) => {
		return null;
	},
} );
