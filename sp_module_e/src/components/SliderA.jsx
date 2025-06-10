import React from 'react';

const SliderA = ({images, imageIndex}) => {

    return (<div className={'slider-container'}>
            <div className="slide-wrapper" style={{marginLeft: `-${imageIndex * 100}`,width:`${images.length * 100}%`}}>
                {images.map(image => {
                    return <div key={image.name} className={'image-container'}>
                        <p className={'image-caption'}>{image.name}</p>
                        <img src={image.image} alt=""/>
                    </div>
                })}
            </div>
        </div>);
};

export default SliderA;