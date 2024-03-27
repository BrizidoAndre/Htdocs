import './styles.css'
import {useEffect, useState} from "react";
import {CreateCard} from "../createCard/createCard";

export const Aside = ({listSelect, select, setSelect}) => {


    const [listComponents, setListComponents] = useState([])

    async function loadComponents() {
        try {
            const address = 'http://localhost/SP/AlatechMachines/api/search/item?category=' + select;

            const res = await fetch(address,{
                headers:{
                    'authorization': 'Bearer ' + localStorage.getItem('token')
                }
            })

            const data = await res.json();

            setListComponents(data);

        } catch (e) {
            console.log('erro na busca de componentes')
            console.log(e.message)
        }
    }


    useEffect(() => {
        loadComponents()
    }, [select]);


    return (<div className="container-aside">

        <select name="componentPart" onChange={(e) => setSelect(e.target.value)}>
            {listSelect.map(item => {
                return (<option value={item.value}>{item.text}</option>)
            })}
        </select>

        <section className="container-aside--cards">
            {listComponents.map(item => {
                return (<CreateCard item={item}/>)
            })}
        </section>

    </div>);
}
