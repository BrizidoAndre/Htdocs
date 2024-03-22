import {useContext, useEffect} from "react";
import {Context} from "../App";

const NavBar = () => {

    const [pageNow, setPageNow] = useContext(Context)




    return (<nav className={"nav"}>


        <a onClick={() => setPageNow('Home')} className={'site-title'}>Site Name</a>
        <ul>
            {
                localStorage.getItem('token') ?
                    <>
                        <CustonLink setPageNow={setPageNow} pageName={'machines'}>Máquinas</CustonLink>
                        <CustonLink setPageNow={setPageNow} pageName={'motherboards'}>Placas-mãe</CustonLink>
                        <CustonLink setPageNow={setPageNow} pageName={'processors'}>Processadores</CustonLink>
                        <CustonLink setPageNow={setPageNow} pageName={'ram-memories'}>Memórias Ram</CustonLink>
                        <CustonLink setPageNow={setPageNow} pageName={'graphic-cards'}>Placas de vídeo</CustonLink>
                        <CustonLink setPageNow={setPageNow} pageName={'storage-devices'}>Dispositivos de armazenamento</CustonLink>
                        <LogoutLink setPageNow={setPageNow}>Logout</LogoutLink>

                    </>

                    :

                    <CustonLink setPageNow={setPageNow} pageName={'Login'}>Login</CustonLink>

            }
        </ul>
    </nav>)
}


export function CustonLink({pageName, setPageNow, children, ...props}) {
    return (
        <li>
            <a onClick={() => setPageNow(pageName)} {...props}>{children}</a>
        </li>
    )
}

function LogoutLink({setPageNow, children, ...props}) {

    async function removeUser() {
        try {
            const localToken = localStorage.getItem('token');
            const data = await fetch('http://localhost/SP/AlatechMachines/api/user/logout', {
                method: 'post',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer ' + localStorage.getItem('token'),
                },
            })

            if (data.ok) {
               localStorage.removeItem('token')
                setPageNow('Login')

            }
        } catch (e) {
            console.log(e.message)
        }
    }

    return (
        <li>
            <a onClick={() => removeUser()}
               {...props}>{children}</a>
        </li>
    )
}

export default NavBar