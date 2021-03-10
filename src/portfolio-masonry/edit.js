const { __ } = wp.i18n; // Import __() from wp.i18n
const { Component, Fragment } = wp.element;
const { withSelect } = wp.data;
const { decodeEntities } = wp.htmlEntities;
import { PanelBody, PanelRow, RangeControl, ToggleControl, Disabled, SelectControl } from '@wordpress/components';
import { InspectorControls } from '@wordpress/block-editor';
import { withState, compose } from '@wordpress/compose';

import Masonry from 'react-masonry-component';
import Thumbnail from './thumbnail';

const masonryOptions = {
	transitionDuration: 103,
	itemSelector: '.portfolio-item',
	gutter: 0,
	percentPosition: true,
};
class masonryPortfolio extends Component {
	componentDidUpdate( prevProps ) {
		// Deselect images when deselecting the block.
		this.props.setAttributes( {
			gutter: 0,
			borderRadius: 0,
		} );
	}
	render() {
		const { posts, className, attributes, setAttributes, columns, setState } = this.props;
		const { borderRadius, overlay, gutter, category } = attributes;
		const imagesLoadedOptions = { background: '.portfolio-item' };

		const onChangeColumn = ( columns ) => {
			setState( { columns } );
			//setAttributes( { columns: columns } );
			{console.log( columns )}
		};

		const onChangeOverlay = ( overlay ) => {
			setAttributes( { overlay: overlay } );
		};
		const onChangeCategory = ( category ) => {
			setAttributes( { category: category } );
		};
		const onChangeGutter = ( gutter ) => {
			setAttributes( { gutter: gutter } );
			
		};
		const onChangeBorderRadius = ( borderRadius ) => {
			setAttributes( { borderRadius: borderRadius } );
		};

		const childElements = posts && posts.map( function( post ) {
			return (
				<li className={ 'portfolio-item ' + columns } key={ post.id } >
					<div className={ 'portfolio-inner' } style={ { margin: gutter + 'px', borderRadius: borderRadius } }>
						{ ( undefined !== post.featured_media && 0 !== post.featured_media ) && (
							<Thumbnail
								id={ post.featured_media }
								link={ post.link }
								alt={ post.title.rendered }
								size={ attributes.imageSize } //set image size, should add this setting on the inspeactorControl
							/>
						) }
						<div className={ 'title ' + overlay }>
							<h2>
								<a href={ post.link } >
									{ decodeEntities( post.title.rendered ) }

								</a>
							</h2>
							{ category &&
								<p>{ __( 'PhotoGraphy', 'swishfolio' ) }</p>
							}
						</div>
					</div>
				</li>
			);
		} );
		return (
			<Fragment>
				<InspectorControls>
					<PanelBody title="Layout Settings" initialOpen={ true }>
						<SelectControl
							label={ __( 'Columns', 'blox-portfolio' ) }
							value={ columns }
							options={ [
								{ label: '1 Column', value: 'col-md-12' },
								{ label: '2 Column', value: 'col-md-6' },
								{ label: '3 Column', value: 'col-md-4' },
								{ label: '4 Column', value: 'col-md-3' },
							] }
							onChange={ onChangeColumn }
						/>
					</PanelBody>
					<PanelBody title="Design" initialOpen={ true }>
						<PanelRow className="__settings-row">

							<SelectControl
								label={ __( 'Title & Category Display', 'blox-portfolio' ) }
								//value={ overlay }
								options={ [
									{ label: 'On Hover', value: 'hover' },
									{ label: 'Modern', value: 'modern' },
									{ label: 'Classic', value: 'classic' },
								] }
								onChange={ onChangeOverlay }
							/>

						</PanelRow>
						<PanelRow className="__settings-row">
							<RangeControl
								label="Border Radius"
								value={ borderRadius }
								onChange={ onChangeBorderRadius }
								min={ 0 }
								max={ 100 }
							/>
						</PanelRow>
						<PanelRow className="__settings-row">
							<RangeControl
								label="Margin"
								value={ gutter }
								onChange={ onChangeGutter }
								min={ 0 }
								max={ 30 }
							/>
						</PanelRow>
						<PanelRow>
							<ToggleControl
								label={ __( 'Show Categories', 'blox-portfolio' ) }
								checked={ category }
								onChange={ onChangeCategory }
							/>
						</PanelRow>
					</PanelBody>
				</InspectorControls>
				<Disabled>
					<Masonry
						className={ 'portfolio-masonry' } // default ''
						elementType={ 'ul' } // default 'div'
						options={ masonryOptions } // default {}
						disableImagesLoaded={ false } // default false
						updateOnEachImageLoad={ false } // default false and works only if disableImagesLoaded is false

					>
						{ childElements }
					</Masonry>

				</Disabled>

			</Fragment >
		);
	}
}
{/**
    use compose to bundle HOC together
*/}
const getPosts = withSelect(
	( select ) => {
		return {
			posts: select( 'core' ).getEntityRecords( 'postType', 'portfolio' ),
		};
	}
);
const rangeState = withState(
	{ columns: 'col-md-3' }
);

export default compose(
	getPosts,
	rangeState
)( masonryPortfolio );

