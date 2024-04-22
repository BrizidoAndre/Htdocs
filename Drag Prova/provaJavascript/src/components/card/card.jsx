import './styles.css'
import {useEffect, useState} from "react";

import icon from '../../assets/icons/setas-para-a-esquerda.png'

export const Card = ({imageName, name}) => {

    const image = fetch('http://localhost/SP/AlatechMachines/api/images/' + imageName);



    return (
        <article className="box-card" draggable={"true"}>

            <img className={"image-component"} src={'http://localhost/SP/AlatechMachines/api/images/' + imageName} alt="Foto do componente eletrônico"/>

            <div className="box-card--bottom">
                <h3 className={'card--name'}>{name}</h3>
                <img className='icon' src={icon} alt="seta para retornar"/>
            </div>
        </article>
    )
}