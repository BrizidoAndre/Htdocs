import './styles.css'
import {useContext, useEffect, useState} from "react";

import icon from '../../assets/icons/setas-para-a-esquerda.png'
import {Tooltip} from "../tooltip/tooltip";
import login from "../../pages/login/login";
import {DragContext} from "../../pages/createMachine/createMachine";

export const CreateCard = ({item}) => {

    const [tip, setTip] = useState(false);

    const [drag, setDrag, newMachine, setNewMachine] = useContext(DragContext)

    function showTool() {
        setTip(true);
        setDrag(item)
    }

    function hideTool() {
        setTip(false)
    }

    return (
        <article className="box-card"
                 draggable={"true"}
                 onMouseEnter={() => showTool()}
                 onMouseLeave={() => hideTool()}>
            <img className={"image-component"} src={'http://localhost/SP/AlatechMachines/api/images/' + item.imageUrl}
                 alt="Foto do componente eletrônico"/>

            <div className="box-card--bottom">
                <h3 className={'card--name'}>{item.name}</h3>
                <img className='icon' src={icon} alt="seta para retornar"/>
            </div>

            {tip ? <Tooltip name={item.name} brand={item.brand.name}/> : null}
        </article>
    )
}