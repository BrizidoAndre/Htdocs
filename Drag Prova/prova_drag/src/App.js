import logo from './logo.svg';
import './App.css';
import {Header} from "./components/header/header";
import {createContext, useState} from "react";
import {Home} from "./pages/home/home";
import {Login} from "./pages/login/login";

export const ChangePage = createContext('Home');
function App() {

    const [pageNow, setPageNow] = useState('Home');

    let Component;


    switch (pageNow) {
        case'Home':
            Component = Home
            break;
        case 'Login':
            Component = Login
            break

    }


    return (
        <ChangePage.Provider value={[pageNow, setPageNow]}>

            <Header/>

            <Component/>

        </ChangePage.Provider>
    );
}

export default App;
