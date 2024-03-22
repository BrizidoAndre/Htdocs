import {useContext, useEffect, useState} from "react";
import {Context} from "../../App";
import {Card} from "../../components/card/card";
import './styles.css'
import {CustonLink} from "../../components/Navbar";

export const Search = () => {

    const [pageNow, setPageNow] = useContext(Context);

    const [list, setList] = useState([]);

    async function loadList() {
        // obtendo o token para a requisição
        const localToken = localStorage.getItem('token')

        const res = await fetch('http://localhost/SP/AlatechMachines/api/' + pageNow,)

        const data = await res.json();

        console.log(data)

        setList(data)
    }

    useEffect(() => {
        loadList()
    }, [pageNow]);

    return (
        <div className={'container-page'}>

                {pageNow ==='machines' ?
                    <button className={'button-nav'} onClick={()=>setPageNow('CreateMachine')}>Criar máquina</button>
                :
                <></>}


            <section className="container-card">

                { list.length > 0 ? list.map(item => {
                    return (
                        <Card name={item.name} imageName={item.imageUrl}/>
                    )
                }): <></>}


            </section>

        </div>
    )
}

export default Search