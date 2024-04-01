import ComponentCard, {
    ComponentCardQuantity, ComponentCardSelect, GraphicCard, MachineCard, MotherboardCard, PowerCard, ProcessorCard
} from "../componentCard/componentCard";
import {memo, useContext, useEffect, useState} from "react";
import './machineForm.css'
import {DragContext} from "../../pages/createMachine/createMachine";
import Login from "../../pages/login/login";

export const MachineForm = ({select}) => {

    // useContext do elemento que está sendo carregado pelo mouse e da máquina a ser cadastrada
    const [drag, setDrag, newMachine, setNewMachine] = useContext(DragContext)


    // useStates para determinar os componentes da máquina
    const [motherboard, setMotherboard] = useState({})
    const [power, setPower] = useState({})
    const [graphic, setGraphic] = useState({})
    const [processor, setProcessor] = useState({})
    const [memoryRam, setMemoryRam] = useState({})

    // useStates para mostrar a lista de armazenamento pro usuário
    const [memoryList, setMemoryList] = useState([])

    // Use state for when we are altering the amount of storage
    // and i nedded something to call the useEffect
    const [callEffect, setCallEffect] = useState('')

    // state for image
    const [image, setImage] = useState()

    // state for telling when the machine is valid and when not it set to true to activate de animation
    const [trigger, setTrigger] = useState('')

    const prepareAnimation = (value) => {
        setTrigger(value)
        // resetando os states para reiniciar a animação
        setTimeout(() => setTrigger(''), 500)
    }

    function motherboardFunction() {
        if (select === 'motherboards') {
            setNewMachine({
                ...newMachine,
                motherboardId: drag.id,
                motherboard: drag
            })
            setMotherboard(drag)
        }
    }
    function powerFunction() {
        if (select === 'power-supplies') {
            setNewMachine({
                ...newMachine,
                powerSupplyId: drag.id,
                powerSupply: drag
            })
            setPower(drag)
        }
    }
    function graphicFunction() {
        if (newMachine.motherboardId && newMachine.powerSupplyId && select === 'graphic-cards') {
            setNewMachine({
                ...newMachine,
                graphicCardId: drag.id
            })
            setGraphic(drag)
        }
    }

    function processorFunction() {
        if (newMachine.motherboardId && newMachine.powerSupplyId && select === 'processors') {
            setNewMachine({
                ...newMachine,
                processorId: drag.id
            })
            setProcessor(drag)
        }
    }

    function memoryFunction() {
        if (newMachine.motherboardId && newMachine.powerSupplyId && select === 'ram-memories') {
            setNewMachine({
                ...newMachine, ramMemoryId: drag.id
            })
            setMemoryRam(drag)
        } else {
        }
    }

    // function for when we are altering the amount of memoryRam in the machine
    function setQuantityMemoryFunction(e) {

        e = parseInt(e)
        setNewMachine({
            ...newMachine, ramMemoryAmount: e
        })
    }

    function memoryListFunction() {
        if (newMachine.motherboardId && newMachine.powerSupplyId && select === 'storage-devices') {

            let newItem = true;
            memoryList.map(e => {
                if (e.name === drag.name) {
                    newItem = false
                }
            })

            if (newItem) {
                setMemoryList([...memoryList, drag,])

                setNewMachine({
                    ...newMachine, storageDevices: memoryList
                })

                // resetando as armadinhas para reiniciar a animação
                setTrigger({memoryRam: true})
                setTimeout(() => setTrigger({}), 500)
                return
            }
        }
    }

    function adaptLists() {
        const lista = []
        memoryList.map(item => {
            lista.push({
                amount: item.amount, storageDeviceId: item.id
            })
        })
        setNewMachine({
            ...newMachine, storageDevices: lista
        })
    }

    function getBase64(file) {
        return new Promise(resolve => {
            let baseURL;
            //     make new Filereader
            let reader = new FileReader();

            //     convert the file to base 64 text
            reader.readAsDataURL(file)

            //     on reader load something
            reader.onload = () => {
                //     make a fileinfo Object
                baseURL = reader.result
                resolve(baseURL);
            };

        })
    }

    const handleFileInputChange = e => {
        let {file} = '';

        file = e.target.files[0];

        getBase64(file).then(result => {

            let code = result.split('base64,')[1]
            setNewMachine({
                ...newMachine,
                imageUrl: code
            });
        })
            .catch(err => {
                console.log(err)
            })
    };
    
    async function verifyMachine() {
        try {
            if (newMachine.motherboardId && newMachine.powerSupplyId) {
                return;

                const res = await fetch('http://localhost/SP/AlatechMachines/api/verify-compatibility', {
                    method: 'post',
                    body: JSON.stringify(newMachine)
                })

                const data = res.json()

                console.log(data)
            }
        } catch (e) {
            console.log(e)
        }
    }


    useEffect(() => {
        adaptLists()
    }, [memoryList, callEffect]);

    useEffect(() => {
        verifyMachine()
    }, [newMachine])

    return (<form className={'form-machine'} onSubmit={e => {
        e.preventDefault()
    }}>

        <ComponentCard
            drag={drag}
            trigger={trigger === 'motherboard'}
            name={'*Placa-mãe'}
            checkSelect={() => motherboardFunction()}
            item={motherboard}/>

        <ComponentCard
            drag={drag}
            trigger={trigger === 'power-supply'}
            name={'*Fonte de alimentação'}
            checkSelect={() => powerFunction()}
            item={power}/>

        <ComponentCard
            drag={drag}
            trigger={trigger === 'processor'}
            name={'Processador'}
            checkSelect={() => {
                processorFunction()
            }}

            item={processor}/>
        <ComponentCard
            drag={drag}
            trigger={trigger === 'graphic-card'}
            name={'Placa de vídeo'}
            checkSelect={() => {
                graphicFunction()
            }}
            item={graphic}/>

        <ComponentCardQuantity
            item={memoryRam}
            checkSelect={memoryFunction}
            setQuantity={setQuantityMemoryFunction}/>

        <ComponentCardSelect
            list={memoryList}
            setList={setCallEffect}
            addList={memoryListFunction}/>

        <MachineCard
            name={newMachine.name}
            setName={(e) => setNewMachine({
                ...newMachine, name: e.target.value
            })}
            description={newMachine.description}
            setDescription={(e) => setNewMachine({
                ...newMachine, description: e.target.value
            })}
            setImage={(e) => handleFileInputChange(e)}
        />


    </form>)
}

export default MachineForm