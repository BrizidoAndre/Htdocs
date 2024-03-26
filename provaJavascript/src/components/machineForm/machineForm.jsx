import ComponentCard, {
    ComponentCardQuantity,
    ComponentCardSelect, GraphicCard,
    MotherboardCard, PowerCard, ProcessorCard
} from "../componentCard/componentCard";
import {useContext, useState} from "react";
import './machineForm.css'
import {DragContext} from "../../pages/createMachine/createMachine";

export const MachineForm = ({select}) => {

    const [drag, setDrag, newMachine, setNewMachine] = useContext(DragContext)

    // useStates para determinar os componentes da máquina
    const [motherboard, setMotherboard] = useState({})
    const [power, setPower] = useState({})
    const [graphic, setGraphic] = useState({})
    const [processor, setProcessor] = useState({})

    const [list, setList] = useState([{
        name: 'Computador',
        imageUrl: 33,

    }, {
        name: 'Computador',
        imageUrl: 33,

    }])

    function motherboardFunction() {
        if (select === 'motherboards') {
            setNewMachine({
                ...newMachine,
                motherboardId: drag.id
            })
            setMotherboard(drag)
        }
    }

    function powerFunction() {
        if (select === 'power-supplies') {
            setNewMachine({
                ...newMachine,
                powerSupplyId: drag.id
            })
            setPower(drag)
        }
    }

    function graphicFunction() {
        if(select ==='graphic-cards'){
            setNewMachine({
                ...newMachine,
                graphicCardId: drag.id
            })
            setGraphic(drag)
        }
    }

    function processorFunction() {
        if (select === 'processors') {
            setNewMachine({
                ...newMachine,
                processorId: drag.id
            })
            setProcessor(drag)
        }
    }

    return (
        <form className={'form-machine'}>


            <ComponentCard name={'Placa-mãe'} checkSelect={motherboardFunction} item={motherboard} setItem={setMotherboard}/>
            <ComponentCard name={'Fonte de alimentação'} checkSelect={powerFunction} item={power} setItem={setPower}/>
            <ComponentCard name={'Placa de vídeo'} checkSelect={graphicFunction} item={graphic} setItem={setGraphic}/>
            <ComponentCard name={'Processador'} checkSelect={processorFunction} item={processor} setItem={setProcessor}/>

            <ComponentCardQuantity select={select} name={'Memória ram'}/>

            <ComponentCardSelect list={list} select={select} name={'Dispositivos de armazenamento'}/>
        </form>
    )
}

export default MachineForm