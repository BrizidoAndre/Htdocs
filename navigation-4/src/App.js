import logo from './logo.svg';
import './App.css';
import {createContext, useContext, useEffect, useState} from "react";
import {Home} from "./pages/home/Home";
import {Link} from "./component/link/Link";
import {eventWrapper} from "@testing-library/user-event/dist/utils";
import {Login} from "./pages/login/login";
import {NotFound} from "./pages/notFound/notFound";

export const NavigationContext = createContext(null);

function App() {

    const [route, setRoute] = useState('/')

    const routes = [{
        route: '/', component: <Home/>
    }, {
        route: '/login', component: <Login/>
    }, {
        route: '/undefined', component: <Home/>
    },
    ]

    function getCurrentPage(){
    const reallyPage = window.location.pathname;
    let allParts = reallyPage.split('/');

    return '/' + reallyPage.split('/')[2]
    }

    useEffect(() => {
        window.addEventListener('popstate', ()=>{})
        return () => {
            window.removeEventListener('popstate', ()=>{});
        }
    }, []);

    let Component = routes.find((item) => {
        return item.route === getCurrentPage();
    })

    Component = Component ? Component.component : <NotFound/>;

    return (<NavigationContext.Provider value={{route,setRoute}}>
            <div className="App">
                <header className="App-header">
                    <Link to={'./'}>Home</Link>
                    {route}
                    <Link to={'./login'}>Login</Link>
                </header>

                {Component}
            </div>
        </NavigationContext.Provider>);
}

export default App;
