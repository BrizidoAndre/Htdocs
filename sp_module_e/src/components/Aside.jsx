import React, {useCallback, useEffect, useRef, useState} from 'react';
import gear from '../assets/setting-icon.png';
import Radio from "./Radio";
import img1 from '../assets/Sample Photos/basilique-notre-dame-de-fourviere-lyon.jpg';
import img2 from '../assets/Sample Photos/beautiful-view-in-lyon.jpg';
import img3 from '../assets/Sample Photos/place-bellecour-lyon.jpg';
import img4 from '../assets/Sample Photos/tour-metalique-lyon.jpg';

const Aside = ({imageIndex, setImageIndex, images, mode, theme, setMode, setTheme, setImages, fullScreen}) => {
    const [isOpened, setIsOpened] = useState(false);
    const repeatAutomatic = useRef(null);
    const repeatRandom = useRef(null);

    function handleClick() {
        setImages([{
            image: img1, name: 'Basilique Notre Dame De Fourviere Lyon'
        }, {
            image: img2, name: 'Beautiful View In Lyon'
        }, {image: img3, name: 'Place Bellecour Lyon'}, {image: img4, name: 'Tour Metalique Lyon'}])
    }

    function clearImages() {
        setImages([])
    }

    function nextSlideAutomatic() {
        clearInterval(repeatRandom.current);
        clearInterval(repeatAutomatic.current);
        repeatAutomatic.current = setInterval(() => {
            setImageIndex(prevState => {
                if (prevState === images.length - 1) {
                    return 0;
                }
                return prevState + 1;
            })
        }, 1000)
    }

    function nextSlideRandom() {
        clearInterval(repeatRandom.current);
        clearInterval(repeatAutomatic.current);
        repeatRandom.current = setInterval(() => {
            setImageIndex(prevState => {
                if (prevState === images.length - 1) {
                    return 0;
                }
                return prevState + 1;
            })
        }, 1000)
    }

    function changeMode(value) {
        if (value === 'automatic') {
            nextSlideAutomatic()
        }
        if (value === 'random') {
            nextSlideRandom()
        }
    }

    function toggleFullscreen(){
        fullScreen.current.requestFullscreen();
        setIsOpened(false);
    }

    useEffect(() => {
        nextSlideAutomatic()
        return()=>{
            console.log('')
        }
    }, []);

    return (<aside className={`menu-lateral ${isOpened && 'menu-open'}`}>
        <img src={gear} onClick={() => setIsOpened(!isOpened)} alt="Gear press it to toggle lateral menu"/>
        <div className="container-menu-lateral">
            <Radio
                onChange={() => {
                    setMode('manual')
                    changeMode('manual')
                }}
                label={'Manual'}
                name={'mode'}
                checked={mode === 'manual'}
            />
            <Radio
                onChange={() => {
                    setMode('automatic')
                    changeMode('automatic')
                }}
                label={'Automatic'}
                name={'mode'}
                checked={mode === 'automatic'}
            />
            <Radio
                onChange={() => {
                    setMode('random')
                    changeMode('random')
                }}
                label={'Random'}
                name={'mode'}
                checked={mode === 'random'}
            />
            <Radio
                onChange={() => setTheme('a')}
                label={'Theme A'}
                name={'theme'}
                checked={theme === 'a'}
            />
            <Radio
                onChange={() => setTheme('b')}
                label={'Theme B'}
                name={'theme'}
                checked={theme === 'b'}
            />
            <Radio
                onChange={() => setTheme('c')}
                label={'Theme C'}
                name={'theme'}
                checked={theme === 'c'}
            />
            <Radio
                onChange={() => setTheme('d')}
                label={'Theme D'}
                name={'theme'}
                checked={theme === 'd'}
            />
            <Radio
                onChange={() => setTheme('e')}
                label={'Theme E'}
                name={'theme'}
                checked={theme === 'e'}
            />
            <Radio
                onChange={() => setTheme('f')}
                label={'Theme F'}
                name={'theme'}
                checked={theme === 'f'}
            />
            <button
                className={'button'}
                onClick={handleClick}>Load default images
            </button>
            <button
                className={'button'}
                onClick={clearImages}>Clear images
            </button><button
                className={'button'}
                onClick={toggleFullscreen}>Toggle Fullscreen
            </button>
        </div>
    </aside>);
};

export default Aside;