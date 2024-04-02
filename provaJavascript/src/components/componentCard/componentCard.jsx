import './componentCard.css'
import noImage from '../../assets/image/no-image.png'
import login from "../../pages/login/login";
import {useContext, useEffect, useState} from "react";
import {DragContext} from "../../pages/createMachine/createMachine";
import {CreateCard} from "../createCard/createCard";


export const ComponentCardQuantity = ({item, checkSelect, setQuantity, trigger}) => {



    return (<div
        className="container-component container-component--select"
        onDragOver={e => e.preventDefault()}
        onDrop={e => {
            // Checando se o componente arrastado é válido ou não
            checkSelect()
        }}
    >

        {/*Esse createCard serve para quando usuário levar um componente que não é válido */}
        {trigger ? <CreateCard animated={true} item={item}/> : <></>}

        <div className={'container-component--text'}>
            <h4>Memória Ram</h4>
            <button>Deletar</button>
        </div>
        <div className="container-component--text">
            <img src={item.imageUrl ? "http://localhost/SP/AlatechMachines/api/images/" + item.imageUrl : noImage}
                 alt=""/>
            {
                item.imageUrl ?
                    <div>
                        <h6>Quantidade</h6>
                        <input type="number" id={'number'} step={1} min={1} defaultValue={0} onChange={(e) => {
                            setQuantity(e.target.value)
                        }}/>
                    </div>

                    :
                    <></>

            }
        </div>

    </div>)
}

export const ComponentCardSelect = ({list, setList, addList}) => {

    const [trigger, setTrigger] = useState(false)

    return (<div
        className="container-component container-component--list"
        onDragOver={e => e.preventDefault()}
        onDrop={e => {
            addList()
        }}
    >

        {/*Esse createCard serve para quando usuário levar um componente que não é válido */}
        {trigger ? <CreateCard animated={true} item={list}/> : <></>}
        <h4>Dispositivos de armazenamento</h4>
        <div className="scroll">
            {list.map(item => {
                return (<div className={'container-flex--space'}>
                    <div className={'container-component--details'}>
                        <img src={"http://localhost/SP/AlatechMachines/api/images/" + item.imageUrl}
                             alt={item.name}/>

                        <div className="details">
                            <p>{item.name}</p>
                            <div className="quantity">
                                <p>Quantidade</p>
                                <input
                                    type="number"
                                    step={1}
                                    min={1}
                                    defaultValue={0}
                                    onChange={(e) => {
                                        item.amount = parseInt(e.target.value)
                                        setList(e.target.value)
                                    }}/>
                            </div>
                        </div>

                    </div>

                    <button
                        onClick={(e) => {
                            e.preventDefault()
                            list.filter(e => e.id)
                        }}
                    >Deletar
                    </button>
                </div>)
            })}
        </div>
    </div>)
}

export const ComponentCard = ({checkSelect, name, item, trigger, drag, deleteAll = null}) => {


    return (
        <>
            <div
                className={`container-component`}
                onDragOver={(e) => {
                    e.preventDefault()
                }}
                onDrop={// Checando se o componente arrastado é válido ou não
                    checkSelect}>


                {/*Esse createCard serve para quando usuário levar um componente que não é válido */}
                {trigger ? <CreateCard animated={true} item={drag}/> : <></>}
                <div className={'container-component--text'}>
                    <h4>{name}</h4>
                    <button >Deletar</button>
                </div>
                <img src={item.imageUrl ? "http://localhost/SP/AlatechMachines/api/images/" + item.imageUrl : noImage}
                     alt=""/>
            </div>
        </>
    )
}

export const MachineCard = ({name, setName, description, setDescription, setImage}) => {
    return (
        <div className="container-component container-component--image">
            <label htmlFor="">Nome</label>
            <input
                type="text"
                onChange={setName}
                value={name}
            />
            <label htmlFor="">Descrição</label>
            <input
                type="text"
                onChange={setDescription}
                value={description}
            />

            <input type="file" onChange={setImage}/>
        </div>
    )
}


export default ComponentCard