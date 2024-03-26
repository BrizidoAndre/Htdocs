import './componentCard.css'
import noImage from '../../assets/image/no-image.png'
import login from "../../pages/login/login";
import {useContext, useState} from "react";
import {DragContext} from "../../pages/createMachine/createMachine";


export const ComponentCardQuantity = () => {

    const [item, setItem] = useState({})
    return (
        <div className="container-component container-component--select">
            <div className={'container-component--text'}>
                <h4>Memória Ram</h4>
                <button>Deletar</button>
            </div>
            <div className="container-component--text">
                <img src={item.imageUrl ? "http://localhost/SP/AlatechMachines/api/images/" + item.imageUrl : noImage}
                     alt=""/>
                <div>
                    <h6>Quantidade</h6>
                    <input type="number" id={'number'} step={1}/>
                </div>
            </div>

        </div>
    )
}

export const ComponentCardSelect = ({list = []}) => {


    return (
        <div className="container-component container-component--list">
            <h4>Dispositivos de armazen.</h4>
            <div className="scroll">
                {list.map(item => {
                    return (
                        <div className={'container-flex--space'}>
                            <div className={'container-component--details'}>
                                <img src={"http://localhost/SP/AlatechMachines/api/images/" + item.imageUrl}
                                     alt={item.name}/>

                                <div className="details">
                                    <p>{item.name}</p>
                                    <div className="quantity">
                                        <p>Quantidade</p>
                                        <input type="number" step={1} min={0}/>
                                    </div>
                                </div>

                            </div>

                            <button>Deletar</button>
                        </div>
                    )
                })}
            </div>
        </div>
    )
}

export const ComponentCard = ({ checkSelect, name, item, setItem}) => {


    return (
        <div className="container-component"
             onDragOver={(e) => {
                 e.preventDefault()
             }}
             onDrop={(e) => {
                 checkSelect()
             }}>
            <div className={'container-component--text'}>
                <h4>{name}</h4>
                <button>Deletar</button>
            </div>
            <img src={item.imageUrl ? "http://localhost/SP/AlatechMachines/api/images/" + item.imageUrl : noImage}
                 alt=""/>
        </div>
    )
}


export default ComponentCard