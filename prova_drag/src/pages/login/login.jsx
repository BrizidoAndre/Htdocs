import {Container} from "../../components/container/container";
import './login.css'

export const Login = () => {


    return (
        <main>
            <Container>
                <div className="container-login">

                    <h1>Login</h1>

                    <form action="">

                        <label htmlFor="name">Username</label>
                        <input type="text" id={'name'}/>

                        <label htmlFor="password">Senha</label>
                        <input type="password" id={'password'}/>

                        <button>Login</button>

                    </form>
                </div>
            </Container>
        </main>
    )
}