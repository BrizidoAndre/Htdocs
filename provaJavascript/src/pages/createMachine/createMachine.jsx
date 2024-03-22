import {Aside} from "../../components/aside/aside";
import './styles.css'
import MachineForm from "../../components/machineForm/machineForm";


export const CreateMachine = () => {
    return(
        <div className={'container-page'}>

            <div className="container-top">
                <h1>Criar nova máquina</h1>
                <button className="button-save">Salvar máquina</button>
            </div>

            <main className={'container-create'}>

                    <Aside />

                    <MachineForm />

            </main>

        </div>
    )
}

export default CreateMachine