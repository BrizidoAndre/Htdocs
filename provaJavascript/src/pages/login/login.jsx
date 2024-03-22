import './login.css'
import {useContext, useEffect, useState} from "react";
import {Context} from "../../App";
import NotLogged from "../../components/modal/notLoged/notLogged";

const Login = () => {

    // obter o context para navegar dentro do react
    const [pageNow, setPageNow] = useContext(Context)

    // const para modal de usuário
    const [missed, setMissed] = useState(false);


    // objeto do usuário para ser realizado o cadastro
    const [user, setUser] = useState({
        username: '',
        password: ''
    })


    const loginUser = async (e) => {
        try {
            // método para não recarregar a página quando submitar o form
            e.preventDefault();

            const res = (await fetch('http://localhost/SP/AlatechMachines/api/user/login', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(user)
            }))

            if (res.ok) {

                const data = await res.json()

                if (data.token) {
                    localStorage.setItem('token', data.token)
                    setPageNow('Home')
                }
            }

            if (res.status === 422){
                setMissed(true)
            }

        } catch (e) {
            console.log('Erro no login');
            console.log(e.message)
        }
    }

    function closeModal() {
        setMissed(false)
        setUser({
            username: '',
            password: ''
        })
    }

    return (
        <div className="container-page">

            <form className={'container-login'} onSubmit={e => loginUser(e)}>
                <label htmlFor="username">Username:</label>
                <input
                    type="text"
                    id={'username'}
                    placeholder={"UserExample..."}
                    value={user.username}
                    autoComplete={'false'}
                    onChange={(e) => setUser({
                        ...user,
                        username: e.target.value
                    })}/>

                <label htmlFor="password">Password</label>
                <input
                    type="password"
                    id={'password'}
                    placeholder={"*******"}
                    value={user.password}
                    onChange={(e) => {
                        setUser({
                            ...user,
                            password: e.target.value
                        })
                    }}/>
                <button>Login</button>
            </form>

            {missed ?
                <NotLogged onClick={() => closeModal()}/>
                :
                null
            }
        </div>
    )
}

export default Login