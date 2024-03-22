import ComponentCard, {ComponentCardQuantity, ComponentCardSelect} from "../componentCard/componentCard";
import {useState} from "react";
import './machineForm.css'

export const MachineForm = () => {


    const [item, setItem] = useState({})
    const [list, setList] = useState([{
        name:'Computador',
        imageUrl:33,

    }])

    return (
        <form className={'form-machine'}>

            <ComponentCard item={item} name={'Placa-mãe'} />
            <ComponentCard item={item} name={'Fonte de alimentação'} />
            <ComponentCard item={item} name={'Processador'} />
            <ComponentCard item={item} name={'Placa de vídeo'} />

            <ComponentCardQuantity item={item} name={'Memória ram'} />

            <ComponentCardSelect list={list}/>
        </form>
    )
}

export default MachineForm