import React, {useEffect, useRef, useState} from 'react';

const CommandBar = ({setCommandBar, setMode, setTheme}) => {
    const [select, setSelect] = useState('manual')

    const options = [
        'manual',
        'automatic',
        'random',
        'a',
        'b',
        'c',
        'd',
        'e',
        'f'
    ]
    const optionsIndex = useRef(0)

    const inputValue = useRef(null);

    function handleKeyPress(ev) {
        let key = ev.key;
        if (key === 'Escape') {
            ev.preventDefault();
            setCommandBar(false);
        }
        if (key === 'ArrowDown' && optionsIndex.current < options.length - 1) {
            optionsIndex.current = optionsIndex.current + 1;
            setSelect(options[optionsIndex.current])
        }
        if (key === 'ArrowUp' && optionsIndex.current > 0) {
            optionsIndex.current = optionsIndex.current - 1;
            setSelect(options[optionsIndex.current])
        }
        if(key === 'Enter'){
            setCommandBar(false);
            if(optionsIndex.current > 2){
                setTheme(inputValue.current.value)
            }
            else{
                setMode(inputValue.current.value)
            }
        }
    }

    useEffect(() => {
        window.addEventListener('keydown', handleKeyPress)
        return () => {
            window.removeEventListener('keydown', handleKeyPress);
        }
    }, [])
    return (<div className={'command-background'}>
        <div className="container-command">
            <div className="w-100">
                <input value={select} ref={inputValue} onChange={(ev)=>setSelect(ev.target.value)} className={'form-control'} type={'text'}/>
            </div>
            <ul>
                <h3>Modes: </h3>
                <li className={`list-item ` + ('manual' === select && 'checked')}>manual</li>
                <li className={`list-item ` + ('automatic' === select && 'checked')}>automatic</li>
                <li className={`list-item ` + ('random' === select && 'checked')}>random</li>
            </ul>
            <ul>
                <h3>Themes:</h3>
                <li className={`list-item ` + ('a' === select && 'checked')}>Theme A</li>
                <li className={`list-item ` + ('b' === select && 'checked')}>Theme B</li>
                <li className={`list-item ` + ('c' === select && 'checked')}>Theme C</li>
                <li className={`list-item ` + ('d' === select && 'checked')}>Theme D</li>
                <li className={`list-item ` + ('e' === select && 'checked')}>Theme E</li>
                <li className={`list-item ` + ('f' === select && 'checked')}>Theme F</li>
            </ul>
        </div>
    </div>);
};

export default CommandBar;