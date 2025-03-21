function setEnergiewerte(energiewert) {
    let formData = new FormData();
    formData.append("portionSize", energiewert.PortionSize);
    formData.append("kalorien", energiewert.Kalorien);
    formData.append("fett", energiewert.Fett);
    formData.append("kohlenhydrate", energiewert.Kohlenhydrate);
    formData.append("zucker", energiewert.Zucker);
    formData.append("eiweiss", energiewert.Eiweiss);

    setEnergiewertToSession(formData);
}