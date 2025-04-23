import { classNames } from "primereact/utils";
import { Menubar } from "primereact/menubar";
import logo from "../../assets/logo.png";
import { NavLink } from "react-router-dom";

const MenuComponent = (props) => {
  const { status, getProgress } = props;

  const itemRenderer = (item) => (
    <NavLink
      to={item.route}
      className="flex align-items-center p-menuitem-link"
      style={{
        textDecoration: "none",
        color: "#495057",
      }}
    >
      <i className={classNames(item.icon, "mr-2")}></i>
      {item.label}
    </NavLink>
  );

  const handleProgressClick = () => {
    getProgress();
  };

  const items = [
    {
      label: "Home",
      icon: "pi pi-home",
      route: "/home",
      template: itemRenderer,
    },
    {
      label: "Upload",
      icon: "pi pi-upload",
      route: "/upload",
      template: itemRenderer,
    },
    {
      label: "Progress",
      icon: `pi ${status && "pi-spin"} pi-spinner-dotted`,
      route: "/progress",
      template: itemRenderer,
      command: handleProgressClick,
    },
  ];

  const start = <img alt="logo" src={logo} height="40" className="mr-2"></img>;

  return (
    <div className="card" style={{ height: "60px", padding: 0 }}>
      <Menubar model={items} start={start} style={{ height: "100%" }} />
    </div>
  );
};

export default MenuComponent;
