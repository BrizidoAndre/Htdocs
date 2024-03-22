import './styles.css'


export const Tooltip = ({name, brand}) => {



    return(
        <div className="tooltip-container">
            <div className="triangle" />

            <div className="tooltip-container--box">
                <label className="item-description">Nome</label>
                <h3>{name}</h3>
                <label className="item-description">Marca</label>
                <h3>{brand}</h3>
            </div>
        </div>
    )
}