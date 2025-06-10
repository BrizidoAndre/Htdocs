import './App.css';
import './css/bootstrap.min.css'
import SliderA from "./components/SliderA";
import React, {useEffect, useRef, useState} from "react";
import Aside from "./components/Aside";
import {formatImageCaption} from "./utils/random";
import CommandBar from "./components/CommandBar";

function App() {
    const [images, setImages] = useState([]);
    const [imageIndex, setImageIndex] = useState(0);
    const [mode, setMode] = useState('automatic');
    const [theme, setTheme] = useState('a')
    const [commandBar, setCommandBar] = useState(false)
    const fullScreen = useRef(null);

    function dropHandler(ev) {
        ev.preventDefault();
        let imageUrl = [];
        // Use DataTransfer interface to access the file(s)
        [...ev.dataTransfer.files].forEach((file, i) => {
            imageUrl.push({
                image: URL.createObjectURL(file), name: formatImageCaption(file.name)
            })
        });
        setImages(imageUrl);
    }

    function showRightTheme() {
        switch (true) {
            case theme === 'a':
                return <SliderA images={images} imageIndex={imageIndex}/>
        }
    }

    function handleFileInput(ev) {
        let imageUrl = [];
        [...ev.target.files].forEach((file, i) => {
            imageUrl.push({
                image: URL.createObjectURL(file), name: formatImageCaption(file.name)
            })
        });
        setImages(imageUrl);
    }

    function showCommandBar(ev) {
        let key = ev.key
        if ((ev.ctrlKey === true && key === 'k') || key === '/') {
            ev.preventDefault()
            setCommandBar(true);
        }
    }

    useEffect(() => {
        window.addEventListener('keydown', showCommandBar);
        return () => {
            window.removeEventListener('keydown', showCommandBar);
        }
    }, [])


    return (<div className={'container-body'} ref={fullScreen}>
        {images.length <= 0 ? <div
            id="drop_zone"
            onDrop={dropHandler}
            onDragOver={(ev) => {
                ev.preventDefault()
            }}
            className={'drop-zone'}
        >
            <p>Drag one or more files to this <i>drop zone</i>.</p>
            <input type="file" onChange={handleFileInput} multiple={true} className={'input-without'}/>
        </div> : showRightTheme()}
        <Aside
            imageIndex={imageIndex}
            setImageIndex={setImageIndex}
            images={images}
            mode={mode}
            theme={theme}
            setMode={setMode}
            setTheme={setTheme}
            setImages={setImages}
            fullScreen={fullScreen}
        />
        {commandBar && <CommandBar
            setMode={setMode}
            setTheme={setTheme}
            setCommandBar={setCommandBar}/>}
    </div>);
}

export default App;
