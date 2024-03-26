import {Aside} from "../../components/aside/aside";
import './styles.css'
import MachineForm from "../../components/machineForm/machineForm";
import {createContext, useState} from "react";

export const DragContext = createContext()

export const CreateMachine = () => {

    const [select, setSelect] = useState('');

    const listSelect = [{
        value: 'motherboards', text: 'Placa-mãe'
    }, {
        value: 'power-supplies', text: 'Fonte de alimentação'
    }, {
        value: 'ram-memories', text: 'Memória ram'
    }, {
        value: 'graphic-cards', text: 'Placa de vídeo'
    }, {
        value: 'storage-devices', text: 'Dispositivo de armazenamento'
    }, {
        value: 'processors', text: 'Processador'
    }]


    const [drag, setDrag] = useState({})
    const [newMachine, setNewMachine] = useState({
        name: "Novo computador do react",
        description: "Um computador criado através do react",
        motherboardId: '',
        powerSupplyId: '',
        processorId: '',
        ramMemoryId: '',
        ramMemoryAmount: '',
        storageDevices:[],
        graphicCardId: '',
        graphicCardAmount: 1,
        imageUrl: ""
    })

    return (
        <DragContext.Provider value={[drag,setDrag,newMachine,setNewMachine]}>

            <div className={'container-page'}>

                <div className="container-top">
                    <h1>Criar nova máquina</h1>
                    <button className="button-save" onClick={()=>{
                        console.log(newMachine)}}>Salvar máquina</button>
                </div>

                <main className={'container-create'}>

                    <Aside listSelect={listSelect} select={select} setSelect={setSelect}/>

                    <MachineForm select={select}/>

                </main>

            </div>
        </DragContext.Provider>
    )
}

export default CreateMachine