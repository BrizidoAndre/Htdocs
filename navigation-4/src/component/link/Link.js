import {useContext} from "react";
import {NavigationContext} from "../../App";


export const Link = ({to, children}) => {

    const {route,setRoute} = useContext(NavigationContext);

    function handleClick(ev){
        ev.preventDefault();
        window.history.pushState(null,'',to)
        setRoute(to);
    }


    return(
        <a href={to} onClick={handleClick}>
            {children}
        </a>
    )
}