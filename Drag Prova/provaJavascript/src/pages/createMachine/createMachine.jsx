import {Aside} from "../../components/aside/aside";
import './styles.css'
import MachineForm from "../../components/machineForm/machineForm";
import {createContext, useContext, useEffect, useState} from "react";
import {Context} from "../../App";

export const DragContext = createContext()

export const CreateMachine = () => {

    // useState global para mudar de página
    const [pageNow, setPageNow] = useContext(Context)

    const [select, setSelect] = useState('motherboards');

    const listSelect = [
        {value: 'motherboards', text: 'Placa-mãe'},
        {value: 'power-supplies', text: 'Fonte de alimentação'},
        {value: 'processors', text: 'Processador'},
        {value: 'graphic-cards', text: 'Placa de vídeo'},
        {value: 'ram-memories', text: 'Memória ram'},
        {value: 'storage-devices', text: 'Dispositivo de armazenamento'},
    ]

    const [drag, setDrag] = useState({})
    const [newMachine, setNewMachine] = useState({
        name: "",
        description: "",
        motherboardId: '',
        powerSupplyId: '',
        processorId: '',
        ramMemoryId: '',
        ramMemoryAmount: '',
        storageDevices: [],
        graphicCardId: '',
        graphicCardAmount: 1,
        imageUrl: ""
    })


    async function postMachine(){
        try{
            console.log(newMachine)
            const res = await fetch('http://localhost/SP/AlatechMachines/api/machines/post',{
                method:'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(newMachine)
            })

            if(res.ok){
                setPageNow('machines')
            }

        } catch(e){
            console.log(e)
        }
    }

    useEffect(() => {
        setNewMachine({
            name: "",
            description: "",
            motherboardId: '',
            powerSupplyId: '',
            processorId: '',
            ramMemoryId: '',
            ramMemoryAmount: '',
            storageDevices: [],
            graphicCardId: '',
            graphicCardAmount: 1,
            imageUrl: ""
        })
    }, []);

    return (
        <DragContext.Provider value={[drag, setDrag, newMachine, setNewMachine]}>

            <div className={'container-page'}>

                <div className="container-top">
                    <h1>Criar nova máquina</h1>
                    <button className="button-save" onClick={() => {
                        console.log(newMachine)
                    }}>Salvar máquina
                    </button>
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