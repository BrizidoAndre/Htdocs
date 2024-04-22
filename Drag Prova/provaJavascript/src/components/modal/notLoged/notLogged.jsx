import './styles.css'

export const NotLogged = ({onClick}) => {


    return (
        <div className="background-modal">
            <div className={'container-modal'}>

                <h1>Login inválido</h1>

                <div className="flex-end">
                    <button onClick={onClick} className={'button-try'}>Tentar novamente</button>

                </div>
            </div>
        </div>
    )
}

export default NotLogged