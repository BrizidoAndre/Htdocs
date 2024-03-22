import Navbar from "./components/Navbar";
import Home from "./pages/home/home";
import './styles.css'
import Login from "./pages/login/login";
import React, {createContext, useEffect, useState} from "react";
import Search from "./pages/search/search";
import CreateMachine from "./pages/createMachine/createMachine";

export const Context = React.createContext()

function App() {

    const [pageNow, setPageNow] = useState('Home');



        let Component
        switch(pageNow) {
            case 'Home':
                Component = Home
                break
            case 'Login':
                Component = Login
                break
            case 'Search':
                Component = Search
                break
            case 'CreateMachine':
                Component = CreateMachine
                break
            default:
                Component = Search
                break;
        }



    return (
        <Context.Provider value={[pageNow, setPageNow]}>
            <Navbar/>
            <div className="center">
                <Component/>
            </div>
        </Context.Provider>
    );
}

export default App;
