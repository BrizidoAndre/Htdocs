import ComponentCard, {ComponentCardQuantity, ComponentCardSelect, MachineCard} from "../componentCard/componentCard";
import {useContext, useEffect, useState} from "react";
import './machineForm.css'
import {DragContext} from "../../pages/createMachine/createMachine";

export const MachineForm = ({select}) => {

    // useContext do elemento que está sendo carregado pelo mouse e da máquina a ser cadastrada
    const [drag, setDrag, newMachine, setNewMachine] = useContext(DragContext)

    // use state para salvar o valor anterior da máquina
    const [oldMachine, setOldMachine] = useState({})


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
        setTimeout(() => setTrigger(''), 495)
    }

    function motherboardFunction() {
        if (select === 'motherboards') {
            setNewMachine({
                ...newMachine, motherboardId: drag.id,
            })
            setMotherboard(drag)
        }
    }

    function powerFunction() {
        if (select === 'power-supplies') {
            setNewMachine({
                ...newMachine, powerSupplyId: drag.id,
            })
            setPower(drag)
        }
    }

    function graphicFunction() {
        if (newMachine.motherboardId && newMachine.powerSupplyId && select === 'graphic-cards') {
            setNewMachine({
                ...newMachine, graphicCardId: drag.id
            })
            setGraphic(drag)
        }
    }

    function processorFunction() {
        if (newMachine.motherboardId && newMachine.powerSupplyId && select === 'processors') {
            setNewMachine({
                ...newMachine, processorId: drag.id
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
                ...newMachine, imageUrl: code
            });
        })
            .catch(err => {
                console.log(err)
            })
    };

    async function verifyMachine() {
        try {
            if (newMachine.motherboardId && newMachine.powerSupplyId) {
                const res = await fetch('http://localhost/SP/AlatechMachines/api/machines/verify-compatibility', {
                    method: 'POST', headers: {
                        'Content-Type': 'application/json'
                    }, body: JSON.stringify(newMachine)
                })

                const data = await res.json();

                const object = {
                    data: data,
                    res:res
                }

                return object;

            }
        } catch (e) {
            console.log(e)
        }
    }

    function seeWhatChanges(){
        console.log(select)
        switch (select){
            case 'motherboards':
                prepareAnimation('motherboard')
                if(motherboard){
                setMotherboard({})
                }
                break
            case 'power-supllies':
                prepareAnimation('power-suplly')
                if(power){
                setPower({})
                }
                break
            case 'processors':
                prepareAnimation('processor')
                if(processor){
                setProcessor({})
                }
                break
            case 'graphic-cards':
                prepareAnimation('graphic-card')
                if(graphic){
                setGraphic({})
                }
                break
        }
    }



    useEffect(() => {
        adaptLists()
    }, [memoryList, callEffect]);


    useEffect(() => {

        verifyMachine().then((e)=>{
            if(!e){
                return
            }
            if(e.res.status !== 200){
                setNewMachine(oldMachine)
                seeWhatChanges()
            }
        })

        setOldMachine(newMachine)
    }, [newMachine]);

    return (<form className={'form-machine'} onSubmit={e => {
        e.preventDefault()
    }}>

        <ComponentCard
            drag={drag}
            trigger={trigger === 'motherboard'}
            name={'*Placa-mãe'}
            checkSelect={() => {
                motherboardFunction()
            }}
            item={motherboard}/>

        <ComponentCard
            drag={drag}
            trigger={trigger === 'power-supply'}
            name={'*Fonte de alimentação'}
            checkSelect={() => {
                powerFunction()
            }}
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