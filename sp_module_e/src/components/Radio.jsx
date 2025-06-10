import React, {useId} from 'react';

const Radio = ({label, onChange, name, checked=false}) => {
    const id = useId();
    return (
        <div className={'container-input'}>
            <label htmlFor={id}>{label}</label>
            <input type="radio" id={id} name={name} onChange={onChange} checked={checked}/>
        </div>
    );
};

export default Radio;