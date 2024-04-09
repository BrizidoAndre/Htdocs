import './header.css'
import {useContext, useState} from "react";
import {Container} from "../container/container";
import {ChangePage} from "../../App";


export const Header = () => {

    const [pageNow, setPageNow] = useContext(ChangePage)

    const [token, setToken] = useState(true);

    return (
        <header>
            <Container>
                <div className="container-header">


                    <h1 onClick={()=> setPageNow('Home')}>Alatech</h1>

                    <nav>

                        {token ?
                            <li onClick={() => setPageNow('Login')}>Login</li>
                            :
                            <>
                                <li>Máquinas</li>
                                <li>Placas-mãe</li>
                                <li>Processadores</li>
                                <li>Memórias RAM</li>
                                <li>Placas de vídeo</li>
                                <li>Dispositivos de armazenamento</li>
                                <li>Logout</li>
                            </>
                        }
                    </nav>


                </div>
            </Container>
        </header>
    )
}
