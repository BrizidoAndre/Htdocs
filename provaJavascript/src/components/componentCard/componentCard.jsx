import './componentCard.css'
import noImage from '../../assets/image/no-image.png'

export const ComponentCard = ({name, item}) => {


    return (
        <div className="container-component">
            <div className={'container-component--text'}>
                <h4>{name}</h4>
                <button>Deletar</button>
            </div>
            <img src={item.imageUrl ? "http://localhost/SP/AlatechMachines/api/images/" + item.imageUrl : noImage}
                 alt=""/>
        </div>
    )
}

export const ComponentCardQuantity = ({item}) => {


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
            <div className="container-flex--space">
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
                                        <input type="number" step={1}/>
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

export default ComponentCard