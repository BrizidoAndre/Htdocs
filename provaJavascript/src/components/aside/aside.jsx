import './styles.css'
import {useEffect, useState} from "react";
import {CreateCard} from "../createCard/createCard";

export const Aside = ({listSelect, select, setSelect}) => {


    const [listComponents, setListComponents] = useState([])

    const [loadIcon, setLoadIcon] = useState(false)

    async function loadComponents() {
        try {
            const address = 'http://localhost/SP/AlatechMachines/api/search/item?category=' + select;

            const res = await fetch(address, {
                headers: {
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
        setLoadIcon(false)
        loadComponents()
        setTimeout(()=>setLoadIcon(true),500)
    }, [select]);


    return (<div className="container-aside">

        <select name="componentPart" onChange={(e) => setSelect(e.target.value)}>
            {listSelect.map(item => {
                return (<option value={item.value}>{item.text}</option>)
            })}
        </select>

        <section className="container-aside--cards">

            {loadIcon ?
                <>
                    {listComponents.map(item => {
                        return (<CreateCard item={item}/>)
                    })}
                </>
                : <div className={'container-icon'}><div className="icon-load"></div></div>}


        </section>

    </div>);
}
